<?php

namespace App\Controller\User;

use App\Entity\User\User;
use App\Controller\Controller;
use App\Event\User\Events;
use App\Event\User\UserEvent;
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
        $form = $this->createForm('registration');

        return $this->render('App:User:register.html.twig', ['form' => $form->createView()]);
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
        $form = $this->createForm('registration', $user);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $this->get('event_dispatcher')->dispatch(Events::REGISTRATION, new UserEvent($user));

            $em->persist($user);
            $em->flush();

            $this->setFlash('success', 'app.user.registration.success');

            return $this->redirectToRoute('homepage');
        }

        $this->setFlash('error', 'app.user.registration.error');

        return $this->render('App:User:register.html.twig', ['form' => $form->createView()]);
    }
}
