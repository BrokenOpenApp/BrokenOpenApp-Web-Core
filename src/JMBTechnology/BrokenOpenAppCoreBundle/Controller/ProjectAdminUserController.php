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
class ProjectAdminUserController extends DefaultProjectViewController
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

		$uipRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:UserInProject');
		$uips = $uipRepo->getForProject($this->project)->setMaxResults(100)->getResult();



		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:ProjectAdminUser:index.html.twig', $this->getViewParameters(array(
			'userInProjects' => $uips,
		)));



	}


}

