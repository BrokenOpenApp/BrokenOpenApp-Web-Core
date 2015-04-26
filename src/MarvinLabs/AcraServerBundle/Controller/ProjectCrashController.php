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

		return $this->render('MLabsAcraServerBundle:ProjectCrash:index.html.twig', $this->getViewParameters(
			array(
				'project'	=> $this->project,
				'crash'      => $crash,
			)));
	}

}


