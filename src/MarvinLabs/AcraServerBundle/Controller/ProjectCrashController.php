<?php

namespace MarvinLabs\AcraServerBundle\Controller;

use Doctrine\ORM\Mapping\Entity;

use Symfony\Component\HttpFoundation\Response;

use MarvinLabs\AcraServerBundle\Controller\DefaultViewController;
use MarvinLabs\AcraServerBundle\Entity\Crash;
use MarvinLabs\AcraServerBundle\DataFixtures\LoadFixtureData;

class ProjectCrashController extends DefaultViewController
{



	protected $project;

	protected function build($projectId) {
		$doctrine = $this->getDoctrine()->getManager();

		$projectRepo = $doctrine->getRepository('MLabsAcraServerBundle:Project');
		$this->project = $projectRepo->findOneById($projectId);
		if (!$this->project) {
			return  new Response( '404' );
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
		$crash = $doctrine->getRepository('MLabsAcraServerBundle:Crash')->findOneBy(array('project'=>$this->project, 'id'=>$crashId));

		if (!$crash) {
			throw $this->createNotFoundException('Unable to find crash.');
		}

		$buildValues = $doctrine->getRepository('MLabsAcraServerBundle:CrashBuild')->findBy(array('crash'=>$crash));
		$crashConfigValues = $doctrine->getRepository('MLabsAcraServerBundle:CrashBuild')->findBy(array('crash'=>$crash));
		$displayValues = $doctrine->getRepository('MLabsAcraServerBundle:CrashDisplay')->findBy(array('crash'=>$crash));
		$envValues = $doctrine->getRepository('MLabsAcraServerBundle:CrashEnvironment')->findBy(array('crash'=>$crash));
		$featuresValues = $doctrine->getRepository('MLabsAcraServerBundle:CrashFeatures')->findBy(array('crash'=>$crash));
		$initialConfigValues = $doctrine->getRepository('MLabsAcraServerBundle:CrashInitialConfiguration')->findBy(array('crash'=>$crash));
		$settingsGlobalValues = $doctrine->getRepository('MLabsAcraServerBundle:CrashSettingsGlobal')->findBy(array('crash'=>$crash));
		$settingsSecureValues = $doctrine->getRepository('MLabsAcraServerBundle:CrashSettingsSecure')->findBy(array('crash'=>$crash));
		$settingsSystemValues = $doctrine->getRepository('MLabsAcraServerBundle:CrashSettingsSystem')->findBy(array('crash'=>$crash));
		$sharedPrefsValues = $doctrine->getRepository('MLabsAcraServerBundle:CrashSharedPreferences')->findBy(array('crash'=>$crash));

		return $this->render('MLabsAcraServerBundle:ProjectCrash:index.html.twig', $this->getViewParameters(
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
				'crash'      => $crash,
			)));
	}

}


