<?php

namespace MarvinLabs\AcraServerBundle\Controller;

use Doctrine\ORM\Mapping\Entity;

use Symfony\Component\HttpFoundation\Response;

use MarvinLabs\AcraServerBundle\Controller\DefaultViewController;
use MarvinLabs\AcraServerBundle\Entity\Crash;
use MarvinLabs\AcraServerBundle\DataFixtures\LoadFixtureData;

class ProjectIssueController extends DefaultViewController
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
	public function indexAction($projectId, $issueId) {
		$doctrine = $this->getDoctrine()->getManager();


		// project
		$return = $this->build($projectId);
		if ($return) {
			return $return;
		}

		// Dashboard
		$crashRepo = $doctrine->getRepository('MLabsAcraServerBundle:Crash');

		$issue = $crashRepo->newIssueDetailsQuery($this->project, $issueId)->getSingleResult();
		$crashes = $crashRepo->newIssueCrashesQuery($this->project, $issueId)->setMaxResults(15)->getResult();

		if (!$issue) {
			throw $this->createNotFoundException('Unable to find issue.');
		}

		return $this->render('MLabsAcraServerBundle:ProjectIssue:index.html.twig', $this->getViewParameters(
			array(
				'project' => $this->project,
				'issue'		=> $issue,
				'crashes'	=> $crashes
			)));
	}

}


