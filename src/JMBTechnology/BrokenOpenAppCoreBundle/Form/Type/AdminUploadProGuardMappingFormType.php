<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class AdminUploadProGuardMappingFormType  extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options) {


		$builder->add('packageName', 'text', array(
			'required' => true,
		));

		$builder->add('app_version_code', 'integer', array(
			'required' => true,
		));

		$builder->add('file', 'file', array(
			'required' => true,
		));

	}

	public function getName() {
		return 'event';
	}

	public function getDefaultOptions(array $options) {
		return array(
			'data_class' => 'JMBTechnology\BrokenOpenAppCoreBundle\Entity\ProGuardMapping',
		);
	}

}

