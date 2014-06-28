<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

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
            ->add('password', null, [
                'label' => 'app.user.registration.form.password'
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
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'registration';
    }
}
