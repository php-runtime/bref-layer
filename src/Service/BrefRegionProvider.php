<?php declare(strict_types=1);

namespace Runtime\BrefLayer\Service;

/**
 * Get all available bref regions.
 */
class BrefRegionProvider
{
    public function getAll(): array
    {
        return json_decode(file_get_contents('https://raw.githubusercontent.com/brefphp/bref/master/runtime/layers/regions.json'), true);
    }
}
