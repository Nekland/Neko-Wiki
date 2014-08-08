<?php

namespace App\Controller;


use App\Entity\Page;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    /**
     * Shows a page
     *
     * @param Page $page
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction(Page $page = null)
    {
        if ($page === null) {
            throw $this->createNotFoundException('No page found');
        }

        return $this->render('NekoWiki:Page:basic.html.twig', [
            'page' => $page
        ]);
    }

    public function newAction(Request $request)
    {
        $page = $this->get('neko_wiki.provider.page')->createPage($request->query->get('title', null));
        $form = $this->createForm('neko_wiki_page', $page);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $page->mergeNewTranslations();
            $this->persistAndFlush($page);

            return $this->redirectToRoute('show_page', ['page_slug' => $page->getTitleSlug()]);
        }

        return $this->render('NekoWiki:Page:new.html.twig', [
            'form'      => $form->createView(),
            'page'      => $page,
            'languages' => $this->get('neko_wiki.language.manager')->getLanguages()
        ]);
    }

    /**
     * Modify an existing page
     * TODO: why the fuck the page parameter would be null ?
     *
     * @param Request $request
     * @param Page $page
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Page $page = null)
    {
        $form = $this->createForm('neko_wiki_page', $page);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $page->mergeNewTranslations();
            $this->getEntityManager()->flush();

            return $this->redirectToRoute('show_page', ['page_slug' => $page->getTitleSlug()]);
        }

        return $this->render('NekoWiki:Page:edit.html.twig', [
            'form'      => $form->createView(),
            'page'      => $page,
            'languages' => $this->get('neko_wiki.language.manager')->getLanguages()
        ]);
    }

    /**
     * Shows a piece of menu with link to translation page
     *
     * @param Page $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showOtherLanguagesAction(Page $page)
    {
        return $this->render('NekoWiki:Page:_other_translations.html.twig', [
            'translations' => $page->getTranslations(),
            'languages'    => $this->get('neko_wiki.language.manager')->getLanguages()
        ]);
    }
}
