<?php

namespace Nekland\NekoWiki\Infrastructure\Exception;

use Symfony\Component\Form\FormView;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WikiNotFoundHttpException extends NotFoundHttpException
{
    /**
     * Search form
     *
     * @var \Symfony\Component\Form\FormView
     */
    private $form;

    /**
     * @param FormView   $form
     * @param string     $message
     * @param \Exception $previous
     */
    public function __construct(FormView $form, $message = null, \Exception $previous = null)
    {
        parent::__construct($message, $previous);

        $this->form = $form;
    }

    /**
     * @return FormView
     */
    public function getForm()
    {
        return $this->form;
    }
}
