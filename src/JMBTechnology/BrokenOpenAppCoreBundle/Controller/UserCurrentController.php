<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class UserCurrentController extends DefaultViewController
{

	public function indexAction(Request $request)
	{



		return $this->render(
			'JMBTechnologyBrokenOpenAppCoreBundle:UserCurrent:index.html.twig',
			array(
			)
		);
	}





}