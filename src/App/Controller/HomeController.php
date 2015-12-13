<?php

namespace App\Controller;
use JMS\Serializer\SerializationContext;
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
     * @param Request     $request
     * @param string|null $_locale
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function languageAction(Request $request, $_locale = null)
    {
        if ($_locale === null) {
            $language = explode('_', $request->getPreferredLanguage())[0];
            $this->getSession()->set('_locale', $language);
            $request->setLocale($language);
        } else {
            $language = $_locale;
        }

        $page = $this->get('neko_wiki.provider.page')->getHomepage();

        if (!$page->getTitleSlug()) {
            $language = $page->getTranslations()->first()->getLocale();
        }

        return $this->redirectToRoute('show_page', ['page_slug' => $page->translate($language)->getTitleSlug(), '_locale' => $language]);
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
            'languages' => $this->get('neko_wiki.language.manager')->getLanguages()
        ]);
    }
}
