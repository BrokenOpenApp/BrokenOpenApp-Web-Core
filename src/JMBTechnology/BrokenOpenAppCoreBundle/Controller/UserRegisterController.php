<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;


use JMBTechnology\BrokenOpenAppCoreBundle\Form\Model\UserRegistration;
use JMBTechnology\BrokenOpenAppCoreBundle\Form\Type\UserRegistrationType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class UserRegisterController extends DefaultViewController
{


	public function registerAction()
	{
		$registration = new UserRegistration();
		$form = $this->createForm(new UserRegistrationType(), $registration, array(
			'action' => $this->generateUrl('account_create'),
		));

		return $this->render(
			'JMBTechnologyBrokenOpenAppCoreBundle:UserRegister:register.html.twig',
			array('form' => $form->createView())
		);
	}

	public function createAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm(new UserRegistrationType(), new UserRegistration());

		$form->handleRequest($request);

		if ($form->isValid()) {
			$registration = $form->getData();

			$factory = $this->get('security.encoder_factory');
			$user =  $registration->getUser();

			$encoder = $factory->getEncoder($user);
			$password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
			$user->setPassword($password);

			$em->persist($user);
			$em->flush();

			return $this->redirect($this->generateUrl('_main_dashboard', array()));
		}

		return $this->render(
			'JMBTechnologyBrokenOpenAppCoreBundle:UserRegister:register.html.twig',
			array('form' => $form->createView())
		);
	}

}

