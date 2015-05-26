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
class ProjectAdminController extends DefaultViewController
{


	protected $project;

	protected function build($projectId)
	{
		$doctrine = $this->getDoctrine()->getManager();

		// load
		$projectRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Project');
		$this->project = $projectRepo->findOneById($projectId);
		if (!$this->project) {
			return new Response('404');
		}

		// permissions
		if (false === $this->get('security.context')->isGranted(ProjectVoter::ADMIN, $this->project)) {
			return new Response('403');
		}

		return null;
	}


	/**
	 *
	 */
	public function indexAction($projectId)
	{

		// project
		$return = $this->build($projectId);
		if ($return) {
			return $return;
		}

		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:ProjectAdmin:index.html.twig', array(
			'project' => $this->project,
		));

	}

	/**
	 *
	 */
	public function ProGuardMappingListAction($projectId)
	{
		$doctrine = $this->getDoctrine()->getManager();

		// project
		$return = $this->build($projectId);
		if ($return) {
			return $return;
		}

		$pgmRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:ProGuardMapping');
		$pgms = $pgmRepo->findBy(array('project'=>$this->project));




		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:ProjectAdmin:proguardMappingList.html.twig', array(
			'project' => $this->project,
			'proguardmappings' => $pgms,
		));


	}


	/**
	 *
	 */
	public function newProGuardMappingAction($projectId)
	{
		$doctrine = $this->getDoctrine()->getManager();

		// project
		$return = $this->build($projectId);
		if ($return) {
			return $return;
		}


		// upload
		$upload = new ProGuardMapping();
		$upload->setProject($this->project);

		$form = $this->createForm(new AdminUploadProGuardMappingFormType(), $upload);

		$request = $this->getRequest();
		if ($request->getMethod() == 'POST') {
			$form->handleRequest($request);

			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($upload);



				$em->flush();
				return $this->redirect($this->generateUrl('_project_admin_proguard_list', array('projectId'=>$this->project->getId())));
			}
		}


		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:ProjectAdmin:newProGuardMapping.html.twig', array(
			'project' => $this->project,
			'form' => $form->createView(),
		));


	}




}

