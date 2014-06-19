<?php

namespace spec\App\Form\Handler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Form\Handler\User');
    }

    /**
     * @param \Symfony\Component\Form\FormFactory    $formFactory
     * @param \App\Form\Type\RegistrationType        $formType
     * @param \Symfony\Component\Form\FormInterface  $form
     */
    function it_should_return_a_form_object($formFactory, $formType, $form)
    {
        $this->beConstructedWith($formFactory, $formType);

        $formFactory->create(Argument::any())->shouldReturn($form);

        $this->getForm()->shouldReturn($form);
    }
}
