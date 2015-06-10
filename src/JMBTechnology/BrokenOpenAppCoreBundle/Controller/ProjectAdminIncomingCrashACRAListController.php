<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;

use Doctrine\ORM\Mapping\Entity;

use JMBTechnology\BrokenOpenAppCoreBundle\Entity\ProGuardMapping;
use JMBTechnology\BrokenOpenAppCoreBundle\Form\Type\AdminUploadProGuardMappingFormType;
use JMBTechnology\BrokenOpenAppCoreBundle\Security\Authorization\Voter\ProjectVoter;
use Symfony\Component\HttpFoundation\Response;

use JMBTechnology\BrokenOpenAppCoreBundle\Controller\DefaultViewController;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash;
use JMBTechnology\BrokenOpenAppCoreBundle\DataFixtures\LoadFixtureData;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class ProjectAdminIncomingCrashACRAListController extends DefaultProjectViewController
{



	/**
	 *
	 */
	public function indexAction($projectId)
	{
		$doctrine = $this->getDoctrine()->getManager();

		// project
		$return = $this->build($projectId, ProjectVoter::ADMIN);
		if ($return) {
			return $return;
		}

		$icaRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:IncomingCrashACRA');
		$icas = $icaRepo->findBy(array('project'=>$this->project));



		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:ProjectAdminIncomingCrashACRAList:index.html.twig', $this->getViewParameters(array(
			'incomingCrashACRAS' => $icas,
		)));



	}


}

