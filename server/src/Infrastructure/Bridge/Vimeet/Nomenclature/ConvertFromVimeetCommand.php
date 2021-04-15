<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Bridge\Vimeet\Nomenclature;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertFromVimeetCommand extends Command
{
    protected static $defaultName = 'app:vimeet:nomenclature-convert-from';

    private Converter $nomenclatureConverter;

    public function __construct(Converter $nomenclatureConverter)
    {
        parent::__construct();

        $this->nomenclatureConverter = $nomenclatureConverter;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Convert an exported nomenclature from vimeet to vimeet365 format')
            ->addArgument('filename', InputArgument::REQUIRED, 'The source filename')
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
        /** @var string $inputFilename */
        $inputFilename = $input->getArgument('filename');
        $inputFile = new \SplFileObject($inputFilename, 'rb');

        /** @var string $outputFilename */
        $outputFilename = $input->getOption('output');
        $outputFile = new \SplFileObject($outputFilename, 'w');

        $this->nomenclatureConverter->convert($inputFile, $outputFile);

        return 0;
    }
}
