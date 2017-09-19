<?php

namespace Nekland\NekoWiki\Controller\User;

use Nekland\NekoWiki\Controller\Controller;

class ProfileController extends Controller
{
    public function profileAction()
    {
        return $this->render('NekoWiki:User:profile.html.twig');
    }
}
