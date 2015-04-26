<?php

namespace MarvinLabs\AcraServerBundle\Controller;

use Doctrine\ORM\Mapping\Entity;

use Symfony\Component\HttpFoundation\Response;

use MarvinLabs\AcraServerBundle\Controller\DefaultViewController;
use MarvinLabs\AcraServerBundle\Entity\Crash;
use MarvinLabs\AcraServerBundle\DataFixtures\LoadFixtureData;

class DashBoardController extends DefaultViewController
{
	
	/**
	 * Render the main dashboard
	 */
	public function indexAction() {
		$doctrine = $this->getDoctrine()->getManager();
        $projectRepo = $doctrine->getRepository('MLabsAcraServerBundle:Project');

		return $this->render('MLabsAcraServerBundle:DashBoard:index.html.twig',  $this->getViewParameters(
        		array(
						'projects'   				=> $projectRepo->findAll(),
					)));
	}


}
