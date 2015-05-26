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
class ProjectApplicationController extends DefaultProjectViewController
{



	/**
	 * Render the dashboard for a particular app
	 */
	public function indexAction($projectId, $packageName) {
		$doctrine = $this->getDoctrine()->getManager();


		// project
		$return = $this->build($projectId);
		if ($return) {
			return $return;
		}

		// Dashboard

		$crashRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Crash');

		$crashes = $crashRepo->newLatestIssuesQuery($this->project, $packageName)->setMaxResults(15)->getResult();


		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:ProjectApplication:index.html.twig',  $this->getViewParameters(
			array(
				'packageName'   		=> $packageName,
				'crashes'   			=> $crashes
			)));
	}

}


