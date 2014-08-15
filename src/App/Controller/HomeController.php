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

    /**
     * Real homepage redirecting to right home
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function languageAction(Request $request)
    {
        $language = explode('_', $request->getPreferredLanguage())[0];
        $this->getSession()->set('_locale', $language);
        $request->setLocale($language);

        $page = $this->get('neko_wiki.provider.page')->getHomepage();

        return $this->redirectToRoute('show_page', ['page_slug' => $page->getTitleSlug(), '_locale' => $language]);
    }
    
    public function homeAction()
    {
        $page_provider = $this->get('neko_wiki.provider.page');

        return $this->render('NekoWiki:Page:basic.html.twig', ['page' => $page_provider->getHomepage()]);
    }

    public function footerAction()
    {
        return $this->render('NekoWiki:Home:_footer.html.twig');
    }

    public function languagePartialAction()
    {
        return $this->render('NekoWiki:Home:_languages.html.twig', [
            'languages' => $this->get('neko_wiki.provider.language')->getLanguages()
        ]);
    }
}
