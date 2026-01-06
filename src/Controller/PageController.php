<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // Nécessaire pour le formulaire
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/cv', name: 'app_cv')]
    public function cv(): Response
    {
        return $this->render('cv/index.html.twig');
    }

    #[Route('/e-portfolio', name: 'app_portfolio')]
    public function portfolio(): Response
    {
        return $this->render('portfolio/index.html.twig');
    }

    #[Route('/pour-en-savoir-plus', name: 'app_loisirs')]
    public function loisirs(): Response
    {
        return $this->render('loisirs/index.html.twig');
    }
    
    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request): Response
    {
        $form = $this->createFormBuilder(null)
            ->add('nom', TextType::class, [
                'label' => 'Votre Nom',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ex: Dupont']
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Votre Prénom',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ex: Jean']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre Email',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ex: contact@email.com']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Accéder au CV',
                'attr' => ['class' => 'btn btn-primary mt-3 w-100']
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->render('inscription/success.html.twig', [
                'nom' => $data['nom'],
                'prenom' => $data['prenom']
            ]);
        }

        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}