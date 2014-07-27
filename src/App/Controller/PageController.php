<?php

namespace App\Controller;


use App\Entity\Page;

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

    public function editAction(Page $page = null)
    {
        $form = $this->createForm('neko_wiki_page', $page);

        return $this->render('NekoWiki:Page:edit.html.twig', [
            'form'      => $form->createView(),
            'page'      => $page,
            'languages' => $this->get('neko_wiki.provider.language')->getLanguages()
        ]);
    }
}
