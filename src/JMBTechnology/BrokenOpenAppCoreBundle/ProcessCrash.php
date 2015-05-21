<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle;

use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Issue;


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

	function __construct($doctrine, $mailer, $twig, $fromEmail)
	{
		$this->doctrine = $doctrine;
		$this->mailer = $mailer;
		$this->twig = $twig;
		$this->fromEmail = $fromEmail;
	}


	function process(Crash $crash) {


		if (!$crash->hasStackTrace() || $crash->getIssue()) {
			return;
		}

		$issueRepo = $this->doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Issue');
		$issueFingerPrint = $crash->computeIssueFingerPrint();
		$issue = $issueRepo->findOneBy(array('fingerprint'=>$issueFingerPrint, 'project'=>$crash->getProject()));
		if (!$issue) {
			$issue = new Issue();
			$issue->setProject($crash->getProject());
			$issue->setFingerprint($issueFingerPrint);
			$issue->setTitleFromCrash($crash);
			$this->doctrine->persist($issue);
		}
		$crash->setIssue($issue);
		$this->doctrine->persist($crash);
		// flush here to try and avoid race conditions; another bug report the same may be coming in at the same time and we might get 2 issues!
		$this->doctrine->flush();


		// TODO send emails


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

