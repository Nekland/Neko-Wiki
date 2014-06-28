<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class HomeController
 *
 * The main controller of our application.
 * Shows the homepage and more.
 */
class HomeController extends Controller
{
    public function homeAction()
    {
        $page_provider = $this->get('neko_wiki.provider.page');

        return $this->render('App:Page:basic.html.twig', ['page' => $page_provider->getHomepage()]);
    }
}
