<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;

use Doctrine\ORM\Mapping\Entity;

use JMBTechnology\BrokenOpenAppCoreBundle\Entity\IncomingCrashACRA;
use JMBTechnology\BrokenOpenAppCoreBundle\JMBTechnologyBrokenOpenAppCoreBundle;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Project;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\UserInProject;
use JMBTechnology\BrokenOpenAppCoreBundle\Form\Type\ProjectNewFormType;
use Symfony\Component\HttpFoundation\Response;

use JMBTechnology\BrokenOpenAppCoreBundle\Controller\DefaultViewController;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash;
use JMBTechnology\BrokenOpenAppCoreBundle\DataFixtures\LoadFixtureData;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class ProjectNewController extends DefaultViewController
{

	public function indexAction()
	{
		// CHECK Permissions
		if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
			throw new AccessDeniedException();
		}

		if (!$this->isCurrentUserCreateProject() ) {
			throw new AccessDeniedException();
		}

		// TODO email verified

		// start project
		$project = new Project();

		$form = $this->createForm(new ProjectNewFormType(), $project);

		$request = $this->getRequest();
		if ($request->getMethod() == 'POST') {
			$form->handleRequest($request);

			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($project);

				$userInProject = new UserInProject();
				$userInProject->setProject($project);
				$userInProject->setUser($this->getUser());
				$userInProject->setIsAdmin(true);
				$userInProject->setIsAccepted(true);
				$em->persist($userInProject);

				$incomingCrashACRA = new IncomingCrashACRA();
				$incomingCrashACRA->setProject($project);
				$incomingCrashACRA->setIncomingCrashKey(JMBTechnologyBrokenOpenAppCoreBundle::createRandomString(1,100));
				$em->persist($incomingCrashACRA);

				$em->flush();
				return $this->redirect($this->generateUrl('_project_index', array('projectId'=>$project->getId())));
			}
		}


		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:NewProject:index.html.twig', array(
			'form' => $form->createView(),
		));


	}




}


