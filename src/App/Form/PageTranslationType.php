<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageTranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', null, [
            'label' => 'app.page.form.title'
        ]);
        $builder->add('content', null, [
            'label' => 'app.page.form.content'
        ]);
        $builder->add('locale', 'hidden');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\PageTranslation',
            'label'      => false
        ]);
    }

    public function getName()
    {
        return 'neko_wiki_page_translation';
    }
}
