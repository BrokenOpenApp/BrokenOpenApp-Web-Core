<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle;

use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Issue;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\User;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class ProcessCrash
{


	protected $doctrine;

	protected $mailer;

	protected $twig;

	protected $fromEmail;

	protected $proguardRetraceJarFileLocation;

	protected $javaLocation;

	function __construct($container)
	{
		$this->doctrine = $container->get('doctrine')->getManager();
		$this->fromEmail = $container->hasParameter('notifications_from') ?
			$container->getParameter('notifications_from') : '';
		$this->javaLocation = $container->hasParameter('jmb_technology_brokenopenapp_core.java_location') ?
			$container->getParameter('jmb_technology_brokenopenapp_core.java_location') : '';
		$this->mailer = $container->get('mailer');
		$this->proguardRetraceJarFileLocation = $container->hasParameter('jmb_technology_brokenopenapp_core.proguard_retrace_jar_file_location') ?
			$container->getParameter('jmb_technology_brokenopenapp_core.proguard_retrace_jar_file_location') : '';
		$this->twig = $container->get('twig');
	}

	function process(Crash $crash) {


		if (!$crash->hasStackTrace() || $crash->getIssue()) {
			return;
		}

		// ============================== ProGuard
		if ($crash->getPackageName() && $crash->getAppVersionCode()) {
			$proGuardMappingRepo = $this->doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:ProGuardMapping');
			$proGuardMapping = $proGuardMappingRepo->findOneBy(array('project' => $crash->getProject(), 'packageName' => $crash->getPackageName(), 'appVersionCode' => $crash->getAppVersionCode()));
			if ($proGuardMapping && $this->proguardRetraceJarFileLocation && file_exists($this->proguardRetraceJarFileLocation) && $this->javaLocation && file_exists($this->javaLocation)) {


				$tempnam = tempnam('/tmp','brokenopenapp_');
				if ($tempnam) {


					file_put_contents($tempnam, $crash->getStackTrace());

					$command = $this->javaLocation . " -jar " .
						$this->proguardRetraceJarFileLocation . " " .
						$proGuardMapping->getAbsolutePath() . " " .
						$tempnam;


					$output = array();
					$return_var = null;

					exec($command, $output, $return_var);

					if ($return_var == 0) {

						$crash->setStackTraceObscured($crash->getStackTrace());
						$crash->setStackTrace(implode("\n",$output));
						$this->doctrine->persist($crash);
					}


					unlink($tempnam);

				}



			}
		}

		// ============================== Issue
		$issueRepo = $this->doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Issue');
		$issueFingerPrint = $crash->computeIssueFingerPrint();
		$issue = $issueRepo->findOneBy(array('fingerprint'=>$issueFingerPrint, 'project'=>$crash->getProject()));
		$newIssue = false;
		if (!$issue) {
			$issue = new Issue();
			$issue->setNumber($issueRepo->getNextIssueNumberForProject($crash->getProject()));
			$issue->setProject($crash->getProject());
			$issue->setFingerprint($issueFingerPrint);
			$issue->setTitleFromCrash($crash);
			$this->doctrine->persist($issue);
			$newIssue = true;
		}
		$crash->setIssue($issue);
		$this->doctrine->persist($crash);

		// ============================== DB work done
		// flush here to try and avoid race conditions; another bug report the same may be coming in at the same time and we might get 2 issues!
		$this->doctrine->flush();

		// ============================== Notifications

		if ($newIssue) {
			$userRepo = $this->doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:User');
			foreach ($userRepo->usersToNotifyOnNewIssue($crash->getProject())->getResult() as $userData) {
				$user = $userRepo->find($userData['id']);
				$this->emailIssue($issue, $crash, $user);
			}
		}


	}

	protected function emailIssue(Issue $issue, Crash $crash, User $user) {

		$message = \Swift_Message::newInstance()
			->setFrom($this->fromEmail)
			->setTo($user->getEmail())
			->setSubject(sprintf(
					'[%s] New Issue: %s',
					$crash->getProject()->getTitle(), $issue->getTitle())
			)
			->setBody(
				$this->twig
					->loadTemplate('JMBTechnologyBrokenOpenAppCoreBundle:Notifications:crash_notification_body.html.twig')
					->render(array('crash' => $crash, 'issue'=>$issue, 'project'=>$crash->getProject()))
			);

		$this->mailer->send($message);
	}

}

