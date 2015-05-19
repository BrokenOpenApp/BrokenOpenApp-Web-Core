<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class UserTypeForRegistration extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('username', 'text');
		$builder->add('email', 'email');
		$builder->add('password', 'repeated', array(
			'first_name'  => 'password',
			'second_name' => 'confirm',
			'type'        => 'password',
		));
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'JMBTechnology\BrokenOpenAppCoreBundle\Entity\User'
		));
	}

	public function getName()
	{
		return 'user';
	}
}

