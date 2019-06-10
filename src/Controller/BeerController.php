<?php

namespace App\Controller;

use App\Form\BeerImportType;
use App\Repository\BeerRepository;
use App\Service\ImportBeer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/beer", name="beer_")
 */
class BeerController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function list(BeerRepository $beerRepository): Response
    {
        $beers = $beerRepository->findAll();
        return $this->render('beer/list.html.twig', [
            'beers' => $beers,
        ]);
    }

    /**
     * @Route("/import", name="import")
     */
    public function import(Request $request, ImportBeer $importBeer): Response
    {
        $form = $this
            ->createForm(BeerImportType::class)
            ->add('download', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $importBeer->importFile($form->get('file')->getData());
            return $this->redirectToRoute('index');
        }

        return $this->render('beer/import.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
