<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('translations', 'collection', [
            'type'      => new PageTranslationType(),
            'allow_add' => true,
            'label'     => false
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Page'
        ]);
    }

    public function getName()
    {
        return 'neko_wiki_page';
    }
}
