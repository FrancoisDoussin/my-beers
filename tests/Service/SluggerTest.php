<?php

namespace App\Tests\Service;

use App\Service\Slugger;
use PHPUnit\Framework\TestCase;

class SluggerTest extends TestCase
{
    /**
     * @dataProvider provideSlug
     */
    public function testSlugify(string $sentence, string $slugProvider): void
    {
        $slugger = new Slugger();
        $slug = $slugger->slugify($sentence);
        $this->assertEquals($slug, $slugProvider);
    }

    public function provideSlug()
    {
        return [
            ["Jean-Claude Van Damme", "jean-claude-van-damme"],
            ["J'adore les pommes", "j-adore-les-pommes"],
            ["10 commandements", "10-commandements"],
            ["Contact moi à l'aide de twitter @test", "contact-moi-a-l-aide-de-twitter-test"]
        ];
    }
}