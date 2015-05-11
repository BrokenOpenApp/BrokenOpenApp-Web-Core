<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;

use Doctrine\ORM\Mapping\Entity;

use Symfony\Component\HttpFoundation\Response;

use JMBTechnology\BrokenOpenAppCoreBundle\Controller\DefaultViewController;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash;
use JMBTechnology\BrokenOpenAppCoreBundle\DataFixtures\LoadFixtureData;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class ProjectController extends DefaultViewController
{



	protected $project;

	protected function build($projectId) {
		$doctrine = $this->getDoctrine()->getManager();

		$projectRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Project');
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

		$crashRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Crash');

		$crashes = $crashRepo->newLatestIssuesQuery($this->project)->setMaxResults(15)->getResult();

		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:Project:index.html.twig', $this->getViewParameters(
			array(
				'project' => $this->project,
				'crashes' => $crashes,
			)));
	}

}


