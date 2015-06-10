<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;



/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class SuperAdminUserListController extends DefaultViewController
{

	public function indexAction()
	{

		$doctrine = $this->getDoctrine()->getManager();

		$uRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:User');
		$users = $uRepo->findBy(array());

		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:SuperAdminUserList:index.html.twig', array(
			'users'=>$users,
		));


	}


}
