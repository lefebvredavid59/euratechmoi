<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\CarouselRepository;
use App\Repository\ProgrammeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     * @param ProgrammeRepository $programmeRepository
     * @param CarouselRepository $carouselRepository
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(ProgrammeRepository $programmeRepository,
                          CarouselRepository $carouselRepository,
                          Request $request,
                          UserPasswordEncoderInterface $passwordEncoder,
                          AuthenticationUtils $authenticationUtils)
    {

        // Inscription

        $user = new User();
        $inscription = $this->createForm(RegistrationFormType::class, $user);
        $inscription->handleRequest($request);
        $error = $authenticationUtils->getLastAuthenticationError();

        if ($inscription->isSubmitted() && $inscription->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $inscription->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            // do anything else you need here, like send an email

            return $this->redirectToRoute('accueil');
        }

        // rendus programme

        $programmes = $programmeRepository->findAll();

        // rendus carousel

        $carousels = $carouselRepository->findAll();

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'programmes' => $programmes,
            'carousels' => $carousels,
            'registrationForm' => $inscription->createView(),
            'error' => $error,
        ]);
    }

    /**
     * @Route("/mentions-legales", name="mentions")
     */
    public function mentions(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $inscription = $this->createForm(RegistrationFormType::class, $user);
        $inscription->handleRequest($request);

        if ($inscription->isSubmitted() && $inscription->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $inscription->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('accueil');
        }

        return $this->render('accueil/mention.html.twig', [
            'controller_name' => 'AccueilController',
            'registrationForm' => $inscription->createView(),
        ]);
    }

    /**
     * @Route("/cgu", name="cgu")
     */
    public function cgu(Request $request,
                        UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $inscription = $this->createForm(RegistrationFormType::class, $user);
        $inscription->handleRequest($request);

        if ($inscription->isSubmitted() && $inscription->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $inscription->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('accueil');
        }

        return $this->render('accueil/conditiongeneral.html.twig', [
            'controller_name' => 'AccueilController',
            'registrationForm' => $inscription->createView(),
        ]);
    }
}
