<?php


namespace App\Controller;


use App\Entity\Enfant;
use App\Form\AjoutEnfantFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AjoutEnfantController extends AbstractController
{
    public function AjoutEnfant(Request $request)
    {
        $enfant = new Enfant();
        $form = $this->createForm(AjoutEnfantFormType::class, $enfant);
//        $form->handleRequest($request):

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$enfant->getUser()) {
                $enfant->setUser($this->getUser());
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enfant);
            $entityManager->flush();
            $this->addFlash('success', 'Votre enfant a bien etait ajoute.');

        }

        return $this->render('accueil/membre.html.twig', [
            'AjoutEnfantForm' => $form->createView(),
        ]);
    }
}
