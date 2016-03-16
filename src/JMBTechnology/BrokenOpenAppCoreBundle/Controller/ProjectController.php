<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;

use Doctrine\ORM\Mapping\Entity;

use JMBTechnology\BrokenOpenAppCoreBundle\Security\Authorization\Voter\ProjectVoter;
use Symfony\Component\HttpFoundation\Response;

use JMBTechnology\BrokenOpenAppCoreBundle\Controller\DefaultViewController;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash;
use JMBTechnology\BrokenOpenAppCoreBundle\DataFixtures\LoadFixtureData;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class ProjectController extends DefaultProjectViewController
{



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


		$incomingCrashACRARepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:IncomingCrashACRA');
		$incomingCrashACRA = $incomingCrashACRARepo->findOneBy(array('project'=>$this->project));


		$host = $this->container->hasParameter('jmb_technology_brokenopenapp_core.incoming_crash_url') ?
			$this->container->getParameter('jmb_technology_brokenopenapp_core.incoming_crash_url') : '';

		$url = (trim($host) ? trim($host) : 'http://'.$this->getRequest()->server->get('HTTP_HOST'))
			.$this->generateUrl('_incoming_crash_acra')
			.'?key='.$incomingCrashACRA->getIncomingCrashKey();

		// Dashboard

		$issueRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Issue');

		$issues = $issueRepo->findBy(array('project'=>$this->project), array('createdAt'=>'DESC'),10);

		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:Project:index.html.twig', $this->getViewParameters(
			array(
				'issues' => $issues,
				'incomingCrashURL' => $url,
			)));
	}

}


