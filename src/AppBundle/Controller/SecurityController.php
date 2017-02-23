<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 2/23/2017
 * Time: 2:44 PM
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\LoginForm;

class SecurityController extends Controller
{

    /**
     * @Route("/login", name="login_page")
     */
    public function loginAction(Request $request)
    {
        $authUtils = $this->get('security.authentication_utils');
        $err = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class, [
           '_username' => $lastUsername
        ]);

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            'error' => $err
        ]);
    }

    /**
     * @Route("/logout", name="logout_page")
     */
    public function logoutAction(Request $request)
    {
        return new Response('Error');
    }

}