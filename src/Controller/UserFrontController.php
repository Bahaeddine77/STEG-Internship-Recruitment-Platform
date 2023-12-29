<?php

namespace App\Controller;

use App\Form\PostulerType;
use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserFrontController extends AbstractController
{
    
    #[Route('/user/front', name: 'app_user_front', methods:"GET")]
    public function home(): Response
    {
    

        return $this->render('user_front/index.html.twig');
    }

    #[Route('/user/front/stage', name: 'app_user_front_stage', methods:"GET")]
    public function index(StageRepository $stageRepository): Response
    {
        $stages=$stageRepository->findAll();
       


        return $this->render('user_front/stages.html.twig', ['stages'=>$stages]);
    }

    #[Route('/user/front/postuler/{id}', name: 'app_user_front_postuler' , methods:"GET|POST")]
    public function create($id, StageRepository $stageRepository, Request $request): Response
    {
        $stage = $stageRepository->find($id);
      
        $form=$this->createForm(PostulerType::class);

            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
                {
                    

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
        
                  
                    return $this->redirectToRoute('app_user_front');
                }
        return $this->render('user_front/postuler.html.twig', [
            'stagiaire' => $form->createView(),
            'stage' => $stage,
        ]);
    }


}
