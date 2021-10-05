<?php declare(strict_types=1);

namespace Runtime\BrefLayer\Command;

use Runtime\BrefLayer\Aws\LayerProvider;
use Runtime\BrefLayer\Service\BrefRegionProvider;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This script updates `layers.json` at the root of the project.
 *
 * `layers.json` contains the layer versions that Bref should use.
 */
class ListCommand
{
    /** @var LayerProvider */
    private $provider;

    /** @var string */
    private $projectDir;

    /** @var BrefRegionProvider */
    private $regionProvider;

    public function __construct(LayerProvider $provider, BrefRegionProvider $regionProvider, string $projectDir)
    {
        $this->provider = $provider;
        $this->projectDir = $projectDir;
        $this->regionProvider = $regionProvider;
    }

    public function __invoke(OutputInterface $output): int
    {
        $output->writeln('Building layers.json');
        $export = [];
        foreach ($this->regionProvider->getAll() as $region) {
            $output->writeln($region);
            $layers = $this->provider->listLayers($region);
            foreach ($layers as $layerName => $version) {
                $layerName = str_replace('bref-', '', $layerName);
                $export[$layerName][$region] = $version;
            }

            $output->writeln(':');
        }
        file_put_contents($this->projectDir . '/layers.json', json_encode($export, \JSON_PRETTY_PRINT));

        return 0;
    }
}
