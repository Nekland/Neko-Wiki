<?php

namespace Nekland\NekoWiki\Controller\User;

use Nekland\NekoWiki\Entity\User\User;
use Nekland\NekoWiki\Controller\Controller;
use Nekland\NekoWiki\Event\User\Events;
use Nekland\NekoWiki\Event\User\UserEvent;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RegistrationController
 */
class RegistrationController extends Controller
{
    /**
     * Shows the registration form
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registrationAction()
    {
        $form = $this->createForm('neko_wiki_registration');

        return $this->render('NekoWiki:User:register.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Register a user and redirect to the qualified page
     *
     * @param  Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('neko_wiki_registration', $user);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('event_dispatcher')->dispatch(Events::REGISTRATION, new UserEvent($user));

            $this->persistAndFlush($user);

            $this->setFlash('success', 'neko_wiki.user.registration.success');

            return $this->redirectToRoute('homepage_by_lang', ['_locale' => $this->getCurrentLocale()]);
        }

        $this->setFlash('error', 'neko_wiki.user.registration.error');

        return $this->render('NekoWiki:User:register.html.twig', ['form' => $form->createView()]);
    }
}
