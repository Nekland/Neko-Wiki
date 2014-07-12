<?php

namespace App\Controller\Admin;


use App\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        $this->render('NekoWiki:Admin:index.html.twig');
    }
}
