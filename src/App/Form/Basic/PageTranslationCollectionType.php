<?php

namespace App\Form\Basic;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PageTranslationCollectionType extends AbstractType
{
    /**
     * Add a default value on pre set data
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            foreach ($data as $name => $value) {
                var_dump($name);
                if (!empty($value)) {
                    $form->get($name)->setData($value);
                }
            }
        });
    }

    public function getParent()
    {
        return 'collection';
    }

    public function getName()
    {
        return 'neko_wiki_page_translation_collection';
    }
}
