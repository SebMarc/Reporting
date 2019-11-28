<?php

namespace App\Controller\Frontend;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class TechController extends AbstractController
{
    /**
     * @Route("/tech/profil", name="tech_profil")
     * @throws UnauthorizedHttpException when user member is not logged in
     */
    public function profil()
    {
        if (!$user = $this->getUser()) {
            throw new UnauthorizedHttpException('', 'Vous devez d\'abord vous connectez pour accéder à cette page');
        }
        return $this->render('frontend/tech/profil.html.twig', [
            'tech' => $user
        ]);
    }

    /**
     * @Route("/tech/client/index", name="tech_clients_list")
     */
    public function clientlist(UserRepository $userRepository) {
        if (!$user = $this->getUser()) {

            throw new UnauthorizedHttpException('', 'Vous devez d\'abord vous connectez pour accéder à cette page');
        }

        $clients= $userRepository->getClientByTechnicien($this->getUser()->getEmail());
        //dd($clients);

        return $this->render('frontend/tech/clientindex.html.twig', [
            'clients' => $clients
        ]);
    }

}
