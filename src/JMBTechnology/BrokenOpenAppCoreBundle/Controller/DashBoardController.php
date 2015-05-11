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
class DashBoardController extends DefaultViewController
{
	
	/**
	 * Render the main dashboard
	 */
	public function indexAction() {
		$doctrine = $this->getDoctrine()->getManager();
        $projectRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Project');

		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:DashBoard:index.html.twig',  $this->getViewParameters(
        		array(
						'projects'   				=> $projectRepo->findAll(),
					)));
	}


}
