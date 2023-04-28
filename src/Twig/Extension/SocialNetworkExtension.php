<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\SocialNetworkExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SocialNetworkExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('socialNetworks', [SocialNetworkExtensionRuntime::class, 'getCachedSocialNetworks']),
        ];
    }
}