<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Entity\RechercheVoiture;
use App\Form\RechercheVoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/voitures", name="admin_voitures")
     */
    public function index(Request $request, PaginatorInterface $paginator, VoitureRepository $repository)
    {
        $rechercheVoiture = new RechercheVoiture();

        $form = $this->createForm(RechercheVoitureType::class, $rechercheVoiture);
        $form->handleRequest($request);

        $voiture = $paginator->paginate(
            $repository->findAllWithPagination($rechercheVoiture),
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('voiture/voitures.html.twig', [
            'voitures' => $voiture,
            'form' => $form->createView(),
            'admin' => true
        ]);
    }

    /**
     * @Route("/admin/ajout", name="admin_ajout_voiture")
     * @Route("/admin/modification/{id}", name="admin_modif_voitures", methods="GET|POST")
     */
    public function modificationEtAjout(Voiture $voiture = null , Request $request, EntityManagerInterface $manager)
    {
        if (!$voiture)
        {
            $voiture = new Voiture();
        }

        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $modif = $voiture->getId() !== null; 
            $manager->persist($voiture);
            $manager->flush();
            $this->addFlash("success", $modif ? "la modification a été effectuée" : "l'ajout a été effectuée");
            return $this->redirectToRoute('admin_voitures');
        }

        return $this->render('admin/modifVoiture.html.twig', [
            'modif' => $voiture->getId() !== null,
            'voiture' => $voiture,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/suppression/{id}", name="admin_suppression_voiture", methods="delete")
     */
    public function suppression(Voiture $voiture, Request $request, EntityManagerInterface $manager)
    {
        if ($this->isCsrfTokenValid('SUP' . $voiture->getId(), $request->get('_token')))
        {
            $manager->remove($voiture);
            $manager->flush();
            $this->addFlash("success", "voiture supprimé");
            return $this->redirectToRoute("admin_voitures");
        }
    }
}
