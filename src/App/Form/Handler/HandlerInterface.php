<?php

namespace App\Form\Handler;


interface HandlerInterface
{
    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getForm();
}
