<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class UserRegistrationType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('user', new UserTypeForRegistration());
		$builder->add(
			'terms',
			'checkbox',
			array('property_path' => 'termsAccepted')
		);
		$builder->add('Register', 'submit');
	}

	public function getName()
	{
		return 'registration';
	}
}

