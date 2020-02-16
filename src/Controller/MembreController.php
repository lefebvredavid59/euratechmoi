<?php


namespace App\Controller;


use App\Entity\Enfant;
use App\Entity\User;
use App\Form\AjoutEnfantFormType;
use App\Form\EditEnfantFormType;
use App\Repository\EnfantRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MembreController extends AbstractController
{
    /**
     * @Route("/membre/{nom}", name="membre")
     */
    public function AjoutEnfant(UserRepository $userRepository,
                                Request $request)
    {
        $membres = $userRepository->findAll();

        // formulaire d'ajout d'enfant

        $this->denyAccessUnlessGranted('ROLE_USER');
        $enfant = new Enfant();
        $ajout = $this->createForm(AjoutEnfantFormType::class, $enfant);
        $ajout->handleRequest($request);

        if ($ajout->isSubmitted() && $ajout->isValid()) {

            if (!$enfant->getUser()) {
                $enfant->setUser($this->getUser());
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enfant);
            $entityManager->flush();
            $this->addFlash('success', 'Votre enfant a bien etait ajoute.');

//            return $this->redirectToRoute('accueil');
        }

        return $this->render('accueil/membre.html.twig', [
            'membres' => $membres,
            'AjoutEnfantForm' => $ajout->createView(),
        ]);
    }

    /**
     * @Route("/enfant/sup/{id}", name="sup_enfant", methods={"POST"})
     */
    public function supEnfant(Request $request,
                              $id,
                              EntityManagerInterface $entityManager)
    {
//        $this->denyAccessUnlessGranted('edit', $enfant);
        if ($this->isCsrfTokenValid('delete', $request->get('token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $enfant = $entityManager->getRepository(Enfant::class)->find($id);
            $entityManager->remove($enfant);
            // On exécute la requête (DELETE...)
            $entityManager->flush();
        }
        return $this->redirectToRoute('membre');
    }

    /**
     * @Route("/enfant/edit/{id}", name="edit_enfant")
     */
    public function editEnfant(Request $request,
                               $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $enfant = $entityManager->getRepository(Enfant::class)->find($id);

        $edit = $this->createForm(EditEnfantFormType::class, $enfant);
        $edit->handleRequest($request);

        if(!$enfant){
            throw $this->createNotFoundException('Cette enfant n\'existe pas');
        }

        if ($edit->isSubmitted()&& $edit->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $this->addFlash('success','La fiche de votre enfant a bien ete modifier.');
        }

        return $this->render('accueil/editEnfant.html.twig', [
            'EditEnfant'=> $edit->createView(),
        ]);
    }
}
