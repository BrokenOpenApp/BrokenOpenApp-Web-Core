<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class IssueEditTitleFormType extends AbstractType {


    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder->add('title', 'text', array(
            'required' => true,
        ));

    }

    public function getName() {
        return 'event';
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'JMBTechnology\BrokenOpenAppCoreBundle\Entity\Issue',
        );
    }
}


