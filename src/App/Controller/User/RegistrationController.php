<?php

namespace App\Controller\User;
use App\Entity\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class RegistrationController
 * @package App\Controller\User
 */
class RegistrationController extends Controller
{
    /**
     * Shows the registration form
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction()
    {
        $form = $this->createForm('registration');

        return $this->render('App:User:register.html.twig', ['form' => $form->createView()]);
    }

    public function doRegistrationAction()
    {
        $user = new User();
        $form = $this->createForm('registration', $user);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
    }
}
