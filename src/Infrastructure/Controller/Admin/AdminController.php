<?php

namespace Nekland\NekoWiki\Infrastructure\Controller\Admin;


use Nekland\NekoWiki\Infrastructure\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        $this->render('NekoWiki:Admin:index.html.twig');
    }
}
