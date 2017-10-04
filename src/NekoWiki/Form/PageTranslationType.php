<?php

namespace Nekland\NekoWiki\Form;

use Nekland\NekoWiki\Entity\PageTranslation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageTranslationType extends AbstractType
{
    /**
     * Build the form dynamically with form data
     *
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var Nekland\NekoWiki\Entity\PageTranslation $translation */
            $translation = $event->getData();
            $builder     = $event->getForm();

            if ($translation === null || (!empty($translation) && $translation->getId() === null) ) {
                $builder->add('title', null, [
                    'label' => 'neko_wiki.page.form.title'
                ]);
            }
            $builder->add('content', null, [
                'label' => 'neko_wiki.page.form.content'
            ]);
            $builder->add('locale', 'hidden');
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Nekland\NekoWiki\Entity\PageTranslation',
            'label'      => false
        ]);
    }

    public function getName()
    {
        return 'neko_wiki_page_translation';
    }
}
