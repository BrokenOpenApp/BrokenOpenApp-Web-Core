<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;



/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class SuperAdminProjectListController extends DefaultSuperAdminController
{

	public function indexAction()
	{

		$doctrine = $this->getDoctrine()->getManager();

		$pRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Project');
		$projects = $pRepo->findBy(array());

		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:SuperAdminProjectList:index.html.twig', array(
			'projects'=>$projects,
		));


	}


}
