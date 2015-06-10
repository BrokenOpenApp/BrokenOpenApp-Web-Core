<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;



/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class SuperAdminController extends DefaultViewController
{

	public function indexAction()
	{

		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:SuperAdmin:index.html.twig', array(
		));


	}


}
