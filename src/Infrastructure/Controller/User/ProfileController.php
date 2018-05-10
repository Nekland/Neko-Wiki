<?php

namespace Nekland\NekoWiki\Infrastructure\Controller\User;


use Nekland\NekoWiki\Infrastructure\Controller\Controller;

class ProfileController extends Controller
{
    public function profileAction()
    {
        return $this->render('User:profile.html.twig');
    }
}
