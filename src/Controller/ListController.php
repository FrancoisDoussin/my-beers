<?php

namespace App\Controller;

use App\Entity\Beer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/list", name="list_")
 */
class ListController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/add/{id}", name="add")
     */
    public function addToList(Beer $beer): RedirectResponse
    {
        if ($this->session->has('beerList')) {
            if (!in_array($beer, $this->session->get('beerList'))) {
                $beers = $this->session->get('beerList');
                $beers[] = $beer;
                $this->session->set('beerList', $beers);
                $this->addFlash(
                    "success",
                    sprintf("You add %s in your list", $beer->getName())
                );
            } else {
                $this->addFlash(
                    'danger',
                    sprintf("%s already in list", $beer->getName()));
            }
        } else {
            $this->session->set('beerList', [$beer]);
            $this->addFlash(
                "success",
                sprintf("You add %s in your list", $beer->getName())
            );
        }

        return $this->redirectToRoute("beer_show", [
            'id' => $beer->getId(),
        ]);
    }

    /**
     * @Route("/list", name="list")
     */
    public function getList(): Response
    {
        return $this->render('list/list.html.twig', [
            'beers' => $this->session->get('beerList'),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteBeer(Beer $beer): RedirectResponse
    {
        $beers = $this->session->get('beerList');
        $position = array_search($beer, $beers);
        unset($beers[$position]);
        $this->session->set('beerList', $beers);
        return $this->redirectToRoute("list_list");
    }

    /**
     * @Route("/clear", name="clear")
     */
    public function clear()
    {
        $this->session->clear();
        return $this->redirectToRoute("list_list");
    }
}