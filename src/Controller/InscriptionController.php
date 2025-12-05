<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request): Response
    {
        // 1. Création du formulaire sans classe dédiée (Builder)
        // Puisqu'on a pas d'entité (Base de données), on laisse null
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

        // 2. Gestion de la requête
        $form->handleRequest($request);

        // 3. Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // C'est ici que la magie opère.
            // On ne sauvegarde RIEN (pas de DB).
            // On récupère juste les données pour dire "Bonjour" (optionnel)
            $data = $form->getData();

            // On redirige vers une page "succès" ou on affiche la vue succès directement
            return $this->render('inscription/success.html.twig', [
                'nom' => $data['nom'],
                'prenom' => $data['prenom']
            ]);
        }

        // 4. Affichage du formulaire (si pas encore soumis)
        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}