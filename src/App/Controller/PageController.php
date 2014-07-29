<?php

namespace App\Controller;


use App\Entity\Page;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    public function showAction(Page $page = null)
    {
        if ($page === null) {
            throw $this->createNotFoundException('No page found');
        }

        return $this->render('NekoWiki:Page:basic.html.twig', [
            'page' => $page
        ]);
    }

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
            'languages' => $this->get('neko_wiki.provider.language')->getLanguages()
        ]);
    }
}
