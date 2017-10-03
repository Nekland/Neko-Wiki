<?php

namespace Nekland\NekoWiki\Form\Basic;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TextTranslatableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('language', 'hidden');
        $builder->add('content', 'text');
        $builder->addEventListener(FormEvents::SUBMIT, [$this, 'submitTranslations']);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'mapped'    => false,
            'allow_add' => true
        ]);
    }

    public function submitTranslations(FormEvent $event)
    {
        $form   = $event->getForm();
        $object = $event->getData();
        var_dump($form->getName());exit;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'text_translatable';
    }

    public function getParent()
    {
        return 'collection';
    }
}
