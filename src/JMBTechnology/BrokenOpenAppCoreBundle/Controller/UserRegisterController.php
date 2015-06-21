<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;


use JMBTechnology\BrokenOpenAppCoreBundle\Entity\UserEmailVerification;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\UserVerifyEmail;
use JMBTechnology\BrokenOpenAppCoreBundle\Form\Model\UserRegistration;
use JMBTechnology\BrokenOpenAppCoreBundle\Form\Type\UserRegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

			$userEmailVerification = new UserVerifyEmail();
			$userEmailVerification->setUser($user);
			$userEmailVerification->setEmail($user->getEmail());

			$em->persist($user);
			$em->persist($userEmailVerification);
			$em->flush();

			$mailer = $this->container->get('mailer');
			$email = $this->container->hasParameter('notifications_from') ? $this->container->getParameter('notifications_from') : '';

			$message = \Swift_Message::newInstance()
				->setFrom($email)
				->setTo($user->getEmail())
				->setSubject('Please verify your email')
				->setBody(
					$this->container->get('twig')
						->loadTemplate('JMBTechnologyBrokenOpenAppCoreBundle:Emails:verifyEmail.html.twig')
						->render(array('user' => $user, 'userEmailVerification'=>$userEmailVerification))
				);
			$mailer->send($message);

			return $this->redirect($this->generateUrl('_main_dashboard', array()));
		}

		return $this->render(
			'JMBTechnologyBrokenOpenAppCoreBundle:UserRegister:register.html.twig',
			array('form' => $form->createView())
		);
	}

	public function verifyEmailAction($user, $key) {

		$em = $this->getDoctrine()->getManager();
		$userRepo = $em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:User');
		$userEmailVerificationRepo = $em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:UserVerifyEmail');

		$userObj = $userRepo->findOneById($user);
		if (!$userObj) {
			return new Response( '404' );
		}

		$userEmailVerifyObj = $userEmailVerificationRepo->findOneBy(array('user'=>$userObj,'key'=>$key));
		if (!$userEmailVerifyObj) {
			return new Response( '404' );
		}

		if ($userEmailVerifyObj->getVerifiedAt()) {
			// TODO? redirect to homepage with a flash message
			return new Response( '404' );
		}


		$userEmailVerifyObj->setVerifiedAt(new \DateTime("", new \DateTimeZone("UTC")));
		$userObj->setIsEmailVerified(true);

		$em->persist($userEmailVerifyObj);
		$em->persist($userObj);
		$em->flush();

		// TODO add flash message

		return $this->redirect($this->generateUrl('_main_dashboard', array()));

	}

}

