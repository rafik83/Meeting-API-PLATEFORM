<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Command\Nomenclature;

use Proximum\Vimeet365\Domain\Repository\NomenclatureRepositoryInterface;
use Proximum\Vimeet365\Infrastructure\Nomenclature\Exporter;
use SplFileObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ExportCommand extends Command
{
    protected static $defaultName = 'app:nomenclature:export';

    private NomenclatureRepositoryInterface $nomenclatureRepository;
    private Exporter $exporter;

    public function __construct(NomenclatureRepositoryInterface $nomenclatureRepository, Exporter $exporter)
    {
        parent::__construct();

        $this->nomenclatureRepository = $nomenclatureRepository;
        $this->exporter = $exporter;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Export as a CSV of an existing Nomenclature')
            ->addArgument('nomenclature', InputArgument::REQUIRED, 'The nomenclature Id')
            ->addOption(
                'output',
                'o',
                InputOption::VALUE_OPTIONAL,
                'Where to save the nomenclature csv (default stdout)',
                'php://stdout'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var string $outputFilename */
        $outputFilename = $input->getOption('output');
        $outputFile = new SplFileObject($outputFilename, 'w');
        $outputFile->setCsvControl(';');

        /** @var int $nomenclatureId */
        $nomenclatureId = $input->getArgument('nomenclature');

        $nomenclature = $this->nomenclatureRepository->findOneById($nomenclatureId);

        if ($nomenclature === null) {
            $io->error(sprintf('Unable to find the nomenclature %d', $nomenclatureId));

            return 1;
        }

        $this->exporter->export($nomenclature, $outputFile);

        return 0;
    }
}
