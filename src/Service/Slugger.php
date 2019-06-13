<?php

namespace App\Service;

class Slugger
{
    public function slugify(string $text): string
    {
        $slug = preg_replace('~[^\pL\d]+~u', '-', $text);
        $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
        $slug = preg_replace('~[^-\w]+~', '', $slug);
        $slug = trim($slug, '-');
        $slug = preg_replace('~-+~', '-', $slug);
        $slug = strtolower($slug);
        return $slug;
    }
}
