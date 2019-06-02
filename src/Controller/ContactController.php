<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swift_Mailer;
use Swift_Message;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, Swift_Mailer $mailer)
    {
        $form = $this
            ->createForm(ContactType::class)
            ->add('submit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new Swift_Message('Contact My Beers'))
                ->setFrom('contact@mybeers.com')
                ->setTo($form->get('email')->getData())
                ->setBody(
                    $this->renderView(
                        'email/contact.html.twig',
                        [
                            'firstName' => $form->get('firstName')->getData(),
                            'lastName' => $form->get('lastName')->getData(),
                        ]
                    ),
                    'text/html'
                )
            ;

            $mailer->send($message);
            $this->addFlash('success', 'Thanks to contact us!');
            return $this->redirectToRoute('index');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
