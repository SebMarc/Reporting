<?php

namespace App\Controller\Backend;

use App\Entity\Shop;
use App\Form\ShopFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/backend/shop/edit", name="backend_shop_edit")
     */
    public function shopedit(Request $request)
    {
        $shop = new Shop();
        $form = $this->createForm(ShopFormType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager= $this->getDoctrine()->getManager();
            $manager->persist($shop);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le magasin a été correctement intégré!'
            );

            return $this->redirectToRoute('homepage'); 
        }

    
        return $this->render('backend/shop/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
