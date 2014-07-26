<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;


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

        return $this->render('NekoWiki:Page:basic.html.twig', ['page' => $page_provider->getHomepage()]);
    }

    public function languageAction(Request $request)
    {
        $language = explode('_', $request->getPreferredLanguage())[0];
        $this->getSession()->set('_locale', $language);
        $request->setLocale($language);

        return $this->redirectToRoute('homepage', ['_locale' => $language]);
    }
}
