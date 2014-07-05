<?php

namespace App\Controller\User;

use App\Controller\Controller;

class ProfileController extends Controller
{
    public function profileAction()
    {
        return $this->render('App:User:profile.html.twig');
    }
}
