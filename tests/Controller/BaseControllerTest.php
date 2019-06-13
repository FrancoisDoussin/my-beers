<?php

namespace App\Tests\Controller;

use Symfony\Component\Panther\PantherTestCase;

class BaseControllerTest extends PantherTestCase
{
    public function testMyApp(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');

        $this->assertContains('My Beers 🍻', $crawler->filter('h1')->html());

        $link = $crawler->selectLink('Contact Us')->link();
        $crawler = $client->click($link);

        $this->assertContains('/contact', $crawler->getUri());
    }
}