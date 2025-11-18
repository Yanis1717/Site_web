<?php
namespace App\Controller;

use App\Form\RegistrationFormType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function register(Request $request): Response
    {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Générer le PDF du CV
            $options = new Options();
            $options->set('defaultFont', 'Arial');
            $dompdf = new Dompdf($options);

            $html = $this->renderView('cv/cv.html.twig', [
                'nom' => 'Yanis LAÏD',
                'user_nom' => $data['nom'],
                'user_prenom' => $data['prenom'],
                'user_email' => $data['email'],
            ]);

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return new Response(
                $dompdf->stream('CV-Yanis.pdf', ['Attachment' => true]),
                Response::HTTP_OK,
                ['Content-Type' => 'application/pdf']
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
