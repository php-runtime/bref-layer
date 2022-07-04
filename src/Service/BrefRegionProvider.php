<?php declare(strict_types=1);

namespace Runtime\BrefLayer\Service;

/**
 * Get all available bref regions.
 */
class BrefRegionProvider
{
    private const JSON_REGIONS_URL = 'https://raw.githubusercontent.com/brefphp/bref/master/runtime/layers/regions.json';

    public function getAll(): array
    {
        return json_decode(file_get_contents(self::JSON_REGIONS_URL), true);
    }
}
