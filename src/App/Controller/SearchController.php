<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    /**
     * Simply show the search form without any layout
     * This action is made to be embed into the global layout
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showSearchFormAction()
    {
        $form = $this->getForm();

        return $this->render('NekoWiki:Search:form.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Redirect to the asked page or the search results page
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function searchRedirectionAction(Request $request)
    {
        $form = $this->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $words = $data['search'];
            $page = $this->get('neko_wiki.provider.page')->searchPage($words, $request->getLocale());

            if ($page !== null) {
                return $this->redirectToRoute('show_page', ['page_slug' => $page->getTitleSlug()]);
            }

            return $this->redirectToRoute('search_results', ['q' => $words]);
        }

        return $this->redirectToRoute('homepage_by_lang', ['_locale' => $this->getCurrentLocale()]);
    }

    /**
     * Show a form to help to search or results
     *
     * @param Request $request
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function resultsAction(Request $request)
    {
        $query = $request->get('q', null);

        if ($query === null) {
            throw $this->createNotFoundException('No query for search.');
        }

        $page = $this->get('neko_wiki.provider.page')->findPageByTitle($query);

        $searcher = $this->get('neko_wiki.searcher');
        $language = $this->get('neko_wiki.language.manager')->getCurrentLanguage();

        return $this->render('NekoWiki:Search:results.html.twig', [
            'mainPager' => $searcher->findForLang($query, $language),
            'otherLangPager' => $searcher->findForAllLanguageExcept($query, $language),
            'query' => $query,
            'potentialMatchPage' => $page
        ]);
    }

    /**
     * Show partial but big search form
     *
     * @param string $content
     * @return Response
     */
    public function completeFormAction($content = '')
    {
        return $this->render('NekoWiki:Search:complete_form.html.twig', [
            'form'    => $this->getForm()->createView(),
            'content' => $content
        ]);
    }

}
