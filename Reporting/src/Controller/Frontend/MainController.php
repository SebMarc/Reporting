<?php

namespace App\Controller\Frontend;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    /**
     * @Route("/",
     *  name="homepage")
     */
    public function index()
    {
        return $this->render('frontend/homepage.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/contact",
     *     name="contact",
     *     methods={"GET", "POST"})
     *
     * @param Request $request
     *
     */
    public function contact(Request $request)
    {
        $contactForm = new Contact();
        $form = $this->createForm(ContactFormType::class, $contactForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager= $this->getDoctrine()->getManager();
            $manager->persist($contactForm);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'email a été envoyé avec succès !'
            );

            return $this->redirectToRoute('homepage');
        }

        return $this->render('frontend/main/contact.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
