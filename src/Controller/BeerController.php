<?php

namespace App\Controller;

use App\Entity\Beer;
use App\Entity\User;
use App\Form\BeerImportType;
use App\Repository\BeerRepository;
use App\Service\ImportBeer;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/beers", name="beer_")
 */
class BeerController extends AbstractController
{
    /**
     * @Route("/random", name="random")
     */
    public function random(): Response
    {
        return $this->render('beer/random.html.twig');
    }

    /**
     * @Route("/randomjson", name="random_json", options={ "expose" = true})
     */
    public function randomJson(BeerRepository $beerRepository): JsonResponse
    {
        $beers = $beerRepository->findAll();
        $beer = $beers[rand(0, count($beers)-1)];

        $datas = [
            'html' => $this->render('beer/detail.html.twig', [
                'beer' => $beer
            ])->getContent()
        ];

        return $this->json($datas);
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request, BeerRepository $beerRepository): Response
    {
        $search = $request->query->get('search');
        $beers = $beerRepository->search($search);

        return $this->render('beer/search.html.twig', [
            "beers" => $beers,
        ]);
    }

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
     * @Route("/show/{id}", name="show")
     */
    public function show(Beer $beer, BeerRepository $beerRepository): Response
    {
        return $this->render('beer/show.html.twig', [
            'beer' => $beer,
        ]);
    }

    /**
     * @Route("/list", name="list-beer")
     */
    public function listBeer(BeerRepository $beerRepository): Response
    {
        $beers = $beerRepository->findAll();
        return $this->render('beer/list-beer.html.twig', [
            'beers' => $beers,
        ]);
    }

    /**
     * @Route("/favorites", name="favorites")
     * @IsGranted("ROLE_USER")
     */
    public function favorites(): Response
    {
        $beers = $this->getUser()->getFavoriteBeers();
        return $this->render('beer/favorites.html.twig', [
            'beers' => $beers,
        ]);
    }

    /**
     * @Route(
     *     "/favorite/{id}",
     *     name="favorite",
     *     options={ "expose" = true }
     * )
     */
    public function favorite(Beer $beer, EntityManagerInterface $entityManager): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($user->getFavoriteBeers()->contains($beer)) {
            $user->removeFavoriteBeer($beer);
        } else {
            $user->addFavoriteBeer($beer);
        }

        $entityManager->persist($user);
        $entityManager->flush();
        return $this->json(true);
    }

    /**
     * @Route(
     *     "/detail/{id}",
     *     name="detail",
     *     options={ "expose" = true }
     * )
     */
    public function detail(Beer $beer): JsonResponse
    {
        $data = [
            'html' => $this->render("beer/detail.html.twig", [
                "beer" => $beer
            ])->getContent()
        ];

        return $this->json($data);
    }

    /**
     * @Route("/import", name="import")
     * @IsGranted("ROLE_USER")
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
