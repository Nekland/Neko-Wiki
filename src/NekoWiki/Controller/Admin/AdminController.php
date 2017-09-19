<?php

namespace Nekland\NekoWiki\Controller\Admin;

use Nekland\NekoWiki\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        $this->render('NekoWiki:Admin:index.html.twig');
    }
}
