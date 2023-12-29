<?php

namespace App\Controller;
use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Form\StagiaireSearchType;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StagiaireController extends AbstractController
{ 
    #[Route('/stagiaire', name: 'app_stagiaire', methods:"GET")]
    public function index(StagiaireRepository $stagiaireRepository): Response
    {
        $stagiaires=$stagiaireRepository->findAll();
       


        return $this->render('stagiaire/index.html.twig', ['stagiaires'=>$stagiaires]);
    }

    #[Route('/stagiaire/search', name: 'app_stagiaire_search', methods: ['GET', 'POST'])]
    public function search(Request $request, StagiaireRepository $stagiaireRepository)
    {
        $form = $this->createForm(StagiaireSearchType::class);
        $form->handleRequest($request);
    
        $results = [];
    
        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = $form->get('criteria')->getData();
            $searchTerm = $form->get('searchTerm')->getData();
    
            if ($criteria && $searchTerm) {
                // Build a query to search for Stagiaires based on the selected criteria and search term
                $results = $stagiaireRepository->findByCriteriaAndSearchTerm($criteria, $searchTerm);
            }
        }
    
        return $this->render('stagiaire/index.html.twig', [
            'form' => $form->createView(), // Pass the form variable to the template
            'results' => $results,
        ]);
    }


    #[Route('/stagiaire/create', name: 'app_stagiaire_create' , methods:"GET|POST")]
    public function create(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $stagiaire= new Stagiaire;
        $form=$this->createForm(StagiaireType::class, $stagiaire);

            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
                {
                    $brochureFile = $form->get('brochure')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $stagiaire->setCV($newFilename);
            }

                    $em->persist($stagiaire);
                    $em->flush();
                    $this->addFlash('success', 'Stagiaire ajouté avec succès !');
                    return $this->redirectToRoute('app_stagiaire');
                }
        return $this->render('stagiaire/create.html.twig', [
            'stagiaire' => $form->createView(),
        ]);
    }

    #[Route('/stagiaire/{id<[0-9]+>}/edit', name: 'app_stagiaire_edit' , methods: ['GET', 'POST' ])]
    public function edit($id, Request $request, StagiaireRepository $stagiaireRepository, EntityManagerInterface $em, SluggerInterface $slugger): Response
{
    $stagiaire = $stagiaireRepository->find($id);

    $form = $this->createForm(StagiaireType::class, $stagiaire);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $brochureFile = $form->get('brochure')->getData();

        // Check if a new CV file is being uploaded
        if ($brochureFile) {
            // Delete the old CV file from the update folder, if it exists
            $oldCVFilename = $stagiaire->getCV();
            if ($oldCVFilename) {
                $oldCVPath = $this->getParameter('brochures_directory') . '/' . $oldCVFilename;
                if (file_exists($oldCVPath)) {
                    unlink($oldCVPath);
                }
            }

            // Handle the new CV file upload as before
            $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

            try {
                $brochureFile->move(
                    $this->getParameter('brochures_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // Handle the exception if something goes wrong during file upload
            }

            // Update the 'CV' property to store the new CV file name
            $stagiaire->setCV($newFilename);
        }

        $em->persist($stagiaire);
        $em->flush();
        $this->addFlash('success', 'Stagiaire modifié avec succès !');
        return $this->redirectToRoute('app_stagiaire');
    }

    return $this->render('stagiaire/edit.html.twig', ['stagiaire' => $stagiaire, 'stagiaire' => $form->createView()]);
}

    #[Route('/stagiaire/{id<[0-9]+>}', name: 'app_stagiaire_delete' , methods:"POST")]
    public function delete($id,StagiaireRepository $stagiaireRepository, Request $request, EntityManagerInterface $em): Response
    {
        $stagiaire = $stagiaireRepository->find($id);
        if($this->isCsrfTokenValid('stagiaire_deletion_'. $stagiaire->getId(), $request->request->get('csrf_token')))
        {
            $cvFilename = $stagiaire->getCV();
            
      
        $em->remove($stagiaire);
        $em->flush();
        // If a CV filename is associated with the Stagiaire, delete the file
        if ($cvFilename) {
            $cvPath = $this->getParameter('brochures_directory') . '/' . $cvFilename;
            if (file_exists($cvPath)) {
                unlink($cvPath);
            }
        }
        $this->addFlash('info', 'Stagiaire supprimé avec succès !');
        }
       

           
        return $this->redirectToRoute('app_stagiaire');
    }
}
