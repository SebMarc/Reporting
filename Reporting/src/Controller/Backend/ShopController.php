<?php

namespace App\Controller\Backend;

use App\Entity\Magasin;
use App\Form\ShopFormType;
use App\Repository\MagasinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/backend/shop/edit/{id}", name="backend_shop_edit", requirements={"id"="\d+"},)
     */
    public function edit(Request $request, Magasin $shop = null)
    {
        if (!$shop) {
            throw $this->createNotFoundException('Le magasin que vous recherchez n\'existe pas !');
        }

   
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

            return $this->redirectToRoute('backend_shops_list'); 
        }

    
        return $this->render('backend/shop/edit.html.twig', [
            'shop' => $shop,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("backend/magasin/index", name="backend_shops_list")
     */
    public function showlist(MagasinRepository $magasinRepository, Request $request)
    {
        $shops = $magasinRepository->findAll();

        $shop = new Magasin();
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

            return $this->redirectToRoute('backend_shops_list');
        }
        return $this->render('backend/magasin/index.html.twig', [
            'shops' => $shops,
            'form' => $form
        ]);

    }
}
