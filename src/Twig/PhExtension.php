<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PhExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('acidity', [$this, 'calculateAcidity']),
        ];
    }

    public function calculateAcidity(?float $ph): ?string
    {
        if ($ph < 5) {
            return "Acide";
        } else {
            return "Doux";
        }
    }
}
