<?php

namespace App\Form\Basic;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TextTranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('langauge', 'hidden');
        $builder->add('content', 'text');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'translation_item';
    }

    public function getParent()
    {
        return 'collection';
    }
}
