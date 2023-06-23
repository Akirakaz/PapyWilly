<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class HTMLEntityDecodeExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('html_entity_decode', [$this, 'htmlEntityDecode']),
        ];
    }

    public function htmlEntityDecode(string $string): string
    {
        return html_entity_decode($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}