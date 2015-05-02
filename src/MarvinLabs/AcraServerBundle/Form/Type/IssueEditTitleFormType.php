<?php

namespace MarvinLabs\AcraServerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormBuilderInterface;


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
            'data_class' => 'MarvinLabs\AcraServerBundle\Entity\Issue',
        );
    }
}


