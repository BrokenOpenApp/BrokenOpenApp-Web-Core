<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;


use JMBTechnology\BrokenOpenAppCoreBundle\Form\Type\ChangePasswordType;
use Symfony\Component\Form\FormError;
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


	public function changePasswordAction() {
		if (false === $this->get('security.context')->isGranted('ROLE_USER'))  throw new AccessDeniedException();

		$user = $this->get('security.context')->getToken()->getUser();

		$done = false;

		$form = $this->createForm(new ChangePasswordType());
		$form->handleRequest($this->getRequest());
		if ($form->isValid()) {

			$formData = $form->getData();
			$newPassword1 = $formData['new_password1'];
			$newPassword2 = $formData['new_password2'];

			if ($newPassword1 != $newPassword2) {
				$form->addError(new FormError("Your new passwords don't match!"));
			} else if (strlen($newPassword1) < 2) {
				$form->addError(new FormError("Your new password was to short!"));
			} else {
				$encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
				$user->setPassword($encoder->encodePassword($newPassword1, $user->getSalt()));

				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($user);
				$em->flush();
				$done = true;

			}

		}


		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:UserCurrent:changePassword.html.twig', array(
			'done'=>$done,
			'form'  => $form->createView(),
		));
	}



}