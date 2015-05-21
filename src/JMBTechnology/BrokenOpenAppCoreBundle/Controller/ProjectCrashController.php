<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;

use Doctrine\ORM\Mapping\Entity;

use Symfony\Component\HttpFoundation\Response;

use JMBTechnology\BrokenOpenAppCoreBundle\Controller\DefaultViewController;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash;
use JMBTechnology\BrokenOpenAppCoreBundle\DataFixtures\LoadFixtureData;
use JMBTechnology\BrokenOpenAppCoreBundle\Security\Authorization\Voter\ProjectVoter;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class ProjectCrashController extends DefaultViewController
{



	protected $project;

	protected function build($projectId) {
		$doctrine = $this->getDoctrine()->getManager();

		// load
		$projectRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Project');
		$this->project = $projectRepo->findOneById($projectId);
		if (!$this->project) {
			return  new Response( '404' );
		}

		// permissions
		if (false === $this->get('security.context')->isGranted(ProjectVoter::READ, $this->project)) {
			return  new Response( '403' );
		}


		return null;
	}

	/**
	 * Render the dashboard for a particular app
	 */
	public function indexAction($projectId, $crashId) {
		$doctrine = $this->getDoctrine()->getManager();


		// project
		$return = $this->build($projectId);
		if ($return) {
			return $return;
		}

		// Crash
		$crash = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Crash')->findOneBy(array('project'=>$this->project, 'id'=>$crashId));

		if (!$crash) {
			throw $this->createNotFoundException('Unable to find crash.');
		}

		$buildValues = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashBuild')->findBy(array('crash'=>$crash));
		$crashConfigValues = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashBuild')->findBy(array('crash'=>$crash));
		$displayValues = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashDisplay')->findBy(array('crash'=>$crash));
		$envValues = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashEnvironment')->findBy(array('crash'=>$crash));
		$featuresValues = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashFeatures')->findBy(array('crash'=>$crash));
		$initialConfigValues = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashInitialConfiguration')->findBy(array('crash'=>$crash));
		$settingsGlobalValues = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashSettingsGlobal')->findBy(array('crash'=>$crash));
		$settingsSecureValues = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashSettingsSecure')->findBy(array('crash'=>$crash));
		$settingsSystemValues = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashSettingsSystem')->findBy(array('crash'=>$crash));
		$sharedPrefsValues = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashSharedPreferences')->findBy(array('crash'=>$crash));
		$customDataValues = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashCustomData')->findBy(array('crash'=>$crash));

		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:ProjectCrash:index.html.twig', $this->getViewParameters(
			array(
				'project'	=> $this->project,
				'buildValues'	=> $buildValues,
				'crashConfigurationValues'	=> $crashConfigValues,
				'displayValues'	=> $displayValues,
				'environmentValues'	=> $envValues,
				'featuresValues'	=> $featuresValues,
				'initialConfigurationValues'	=> $initialConfigValues,
				'settingsGlobalValues'	=> $settingsGlobalValues,
				'settingsSecureValues'	=> $settingsSecureValues,
				'settingsSystemValues'	=> $settingsSystemValues,
				'sharedPreferencesValues'	=> $sharedPrefsValues,
				'customDataValues'	=> $customDataValues,
				'crash'      => $crash,
			)));
	}

}


