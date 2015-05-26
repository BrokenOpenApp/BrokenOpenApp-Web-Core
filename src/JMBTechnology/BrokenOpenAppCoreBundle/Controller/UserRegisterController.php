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

	protected function isAllowed() {
		if (!$this->container->hasParameter('jmb_technology_brokenopenapp_core.user_registration_allowed')) {
			return false;
		}

		return $this->container->getParameter('jmb_technology_brokenopenapp_core.user_registration_allowed');
	}

	public function registerAction()
	{
		if (!$this->isAllowed()) {
			return $this->render(
				'JMBTechnologyBrokenOpenAppCoreBundle:UserRegister:notAllowed.html.twig',
				array()
			);
		}


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
		if (!$this->isAllowed()) {
			return $this->render(
				'JMBTechnologyBrokenOpenAppCoreBundle:UserRegister:notAllowed.html.twig',
				array()
			);
		}

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

			if ($this->container->hasParameter('jmb_technology_brokenopenapp_core.new_registered_users_are_given_create_project')) {
				$user->setIsCreateProject((boolean)$this->container->getParameter('jmb_technology_brokenopenapp_core.new_registered_users_are_given_create_project'));
			} else {
				$user->setIsCreateProject(false);
			}

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

