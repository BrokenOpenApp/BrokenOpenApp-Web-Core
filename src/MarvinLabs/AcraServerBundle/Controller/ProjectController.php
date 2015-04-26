<?php

namespace MarvinLabs\AcraServerBundle\Controller;

use Doctrine\ORM\Mapping\Entity;

use Symfony\Component\HttpFoundation\Response;

use MarvinLabs\AcraServerBundle\Controller\DefaultViewController;
use MarvinLabs\AcraServerBundle\Entity\Crash;
use MarvinLabs\AcraServerBundle\DataFixtures\LoadFixtureData;

class ProjectController extends DefaultViewController
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
	 * Render the main dashboard
	 */
	public function indexAction($projectId)
	{
		$doctrine = $this->getDoctrine()->getManager();

		// project
		$return = $this->build($projectId);
		if ($return) {
			return $return;
		}

		// Dashboard

		$crashRepo = $doctrine->getRepository('MLabsAcraServerBundle:Crash');

		$crashes = $crashRepo->newLatestIssuesQuery($this->project)->setMaxResults(15)->getResult();
		$applicationStatistics = $crashRepo->newApplicationsStatisticsQuery($this->project)->getResult();
		$timeStatistics = $crashRepo->newApplicationsTimeStatisticsQuery($this->project)->getResult();

		return $this->render('MLabsAcraServerBundle:Project:index.html.twig', $this->getViewParameters(
			array(
				'project' => $this->project,
				'crashes' => $crashes,
				'timeStatistics' => $timeStatistics,
				'applicationStatistics' => $applicationStatistics
			)));
	}

}


