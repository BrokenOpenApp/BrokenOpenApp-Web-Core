<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class ChangePasswordType  extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('old_password', 'password', array('label'=>'Old password','required'=>true, 'mapped' => false, 'constraints' => new UserPassword()));
		$builder->add('new_password1', 'password', array('label'=>'New password','required'=>true));
		$builder->add('new_password2', 'password', array('label'=>'Repeat new password','required'=>true));
	}

	public function getName() {
		return 'changepassword';
	}

	public function getDefaultOptions(array $options) {
		return array(
		);
	}

}
