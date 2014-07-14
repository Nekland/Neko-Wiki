<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Very simple registration form type
 */
class RegistrationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
                'label' => 'app.user.registration.form.username'
            ])
            ->add('password', 'repeated', [
                'type'  => 'password',
                'first_options' => [
                    'label' => 'app.user.registration.form.password'
                ],
                'second_options' => [
                    'label' => 'app.user.registration.form.password_repeat'
                ]
            ])
            ->add('email', null, [
                'label' => 'app.user.registration.form.email'
            ])
            ->add('submit', 'submit', [
                'label' => 'app.user.registration.form.submit'
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\User\User',
            'intention'  => 'registration',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'neko_wiki_registration';
    }
}
