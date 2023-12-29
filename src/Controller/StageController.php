<?php

namespace App\Controller;
use App\Entity\Stage;
use App\Form\StageType;
use App\Repository\StageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StageController extends AbstractController
{
    #[Route('/stage', name: 'app_stage', methods:"GET")]
    public function index(StageRepository $stageRepository): Response
    {
        $stages=$stageRepository->findAll();
       


        return $this->render('stage/index.html.twig', ['stages'=>$stages]);
    }

    #[Route('/stage/create', name: 'app_stage_create' , methods:"GET|POST")]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $stage= new Stage;
        $form=$this->createForm(StageType::class, $stage);

            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
                {
                    $em->persist($stage);
                    $em->flush();
                    $this->addFlash('success', 'Stage ajouté avec succès !');
                    return $this->redirectToRoute('app_stage');
                }
        return $this->render('stage/create.html.twig', [
            'stage' => $form->createView(),
        ]);
    }

    #[Route('/stage/{id<[0-9]+>}/edit', name: 'app_stage_edit' , methods: ['GET', 'POST' ])]
    public function edit($id, Request $request,StageRepository $stageRepository, EntityManagerInterface $em): Response
    {
        $stage = $stageRepository->find($id);

        $form=$this->createForm(StageType::class, $stage);

            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
                {
                    $em->persist($stage);
                    $em->flush();
                    $this->addFlash('success', 'Stage modifié avec succès !');
                    return $this->redirectToRoute('app_stage');
                }
        return $this->render('stage/edit.html.twig', ['stage' => $stage, 'stage'=>$form->createView()]);
    }

    #[Route('/stage/{id<[0-9]+>}', name: 'app_stage_delete' , methods:"POST")]
    public function delete($id,StageRepository $stageRepository, Request $request, EntityManagerInterface $em): Response
    {
        $stage = $stageRepository->find($id);
        if($this->isCsrfTokenValid('stage_deletion_'. $stage->getId(), $request->request->get('csrf_token')))
        {
            
      
        $em->remove($stage);
        $em->flush();
        $this->addFlash('info', 'Stage supprimé avec succès !');
        }
       

           
        return $this->redirectToRoute('app_stage');
    }

}
