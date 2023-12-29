<?php

namespace App\Controller;
use App\Entity\Encadrant;
use App\Form\EncadrantType;
use App\Repository\EncadrantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EncadrantController extends AbstractController
{
    #[Route('/encadrant', name: 'app_encadrant', methods:"GET")]
    public function index(EncadrantRepository $encadrantRepository): Response
    {
        $encadrants=$encadrantRepository->findAll();
       


        return $this->render('encadrant/index.html.twig', ['encadrants'=>$encadrants]);
    }

    #[Route('/encadrant/create', name: 'app_encadrant_create' , methods:"GET|POST")]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $encadrant= new Encadrant;
        $form=$this->createForm(EncadrantType::class, $encadrant);

            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
                {
                    $em->persist($encadrant);
                    $em->flush();
                    $this->addFlash('success', 'Encadrant ajouté avec succès !');
                    return $this->redirectToRoute('app_encadrant');
                }
        return $this->render('encadrant/create.html.twig', [
            'formEncadrant' => $form->createView(),
        ]);
    }

    #[Route('/encadrant/{id<[0-9]+>}/edit', name: 'app_encadrant_edit' , methods:['GET', 'POST' ])]
    public function edit($id, Request $request, EncadrantRepository $encadrantRepository, EntityManagerInterface $em): Response
{
    $encadrant = $encadrantRepository->find($id);

    if (!$encadrant) {
        // Handle the case where the Encadrant entity with the given ID is not found.
        throw $this->createNotFoundException('The Encadrant does not exist');
    }

    $form = $this->createForm(EncadrantType::class, $encadrant);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($encadrant);
            $em->flush();
            $this->addFlash('success', 'Encadrant modifié avec succès !');
            return $this->redirectToRoute('app_encadrant');
        } 
    

    return $this->render('encadrant/edit.html.twig', ['formEncadrant' => $form->createView()]);
}




    #[Route('/encadrant/{id<[0-9]+>}', name: 'app_encadrant_delete' , methods:"POST")]
    public function delete($id,EncadrantRepository $encadrantRepository, Request $request, EntityManagerInterface $em): Response
    {
        $encadrant = $encadrantRepository->find($id);
        if($this->isCsrfTokenValid('encadrant_deletion_'. $encadrant->getId(), $request->request->get('csrf_token')))
        {
            
      
        $em->remove($encadrant);
        $em->flush();
        $this->addFlash('info', 'Encadrant supprimé avec succès !');
        }
       

           
        return $this->redirectToRoute('app_encadrant');
    }

    #[Route('/encadrant/stagiaires/{id}', name: 'app_encadrant_stagiaires', methods:"GET")]
    public function stagiaires($id, EncadrantRepository $encadrantRepository): Response
    {
        $encadrant = $encadrantRepository->find($id);

        if (!$encadrant) {
            // Handle the case where the Encadrant entity with the given ID is not found.
            throw $this->createNotFoundException('The Encadrant does not exist');
        }

        $stagiaires = $encadrant->getStagiaire();
       


        return $this->render('encadrant/stagiaires.html.twig', [
            'stagiaires'=>$stagiaires,
            'encadrant'=>$encadrant,
        ]);
    }


}
