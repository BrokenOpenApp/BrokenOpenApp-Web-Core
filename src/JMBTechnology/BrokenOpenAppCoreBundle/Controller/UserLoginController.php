<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class UserLoginController extends DefaultViewController
{

	public function loginAction(Request $request)
	{

		$session = $request->getSession();

		// get the login error if there is one
		if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
			$error = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
		} elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
			$error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
			$session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
		} else {
			$error = null;
		}

		// last username entered by the user
		$lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

		return $this->render(
			'JMBTechnologyBrokenOpenAppCoreBundle:UserLogin:login.html.twig',
			array(
				// last username entered by the user
				'last_username' => $lastUsername,
				'error'         => $error,
			)
		);
	}





}