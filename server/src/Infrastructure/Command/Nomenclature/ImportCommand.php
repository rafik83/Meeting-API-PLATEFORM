<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Infrastructure\Command\Nomenclature;

use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Application\Adapter\CommandBusInterface;
use Proximum\Vimeet365\Application\Command\Nomenclature\ImportCommand as NomenclatureImportCommand;
use Proximum\Vimeet365\Domain\Entity\Nomenclature;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportCommand extends Command
{
    protected static $defaultName = 'app:nomenclature:import';

    private ManagerRegistry $managerRegistry;
    private CommandBusInterface $commandBus;

    public function __construct(ManagerRegistry $managerRegistry, CommandBusInterface $commandBus)
    {
        parent::__construct();

        $this->managerRegistry = $managerRegistry;
        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Fill an existing Nomenclature from a csv file')
            ->addArgument('nomenclature', InputArgument::REQUIRED)
            ->addArgument('filename', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $nomenclatureRepository = $this->managerRegistry->getRepository(Nomenclature::class);

        /** @var int $nomenclatureId */
        $nomenclatureId = $input->getArgument('nomenclature');

        /** @var Nomenclature|null $nomenclature */
        $nomenclature = $nomenclatureRepository->find($nomenclatureId);

        if ($nomenclature === null) {
            $io->error(sprintf('Unable to find the nomenclature with id %d', $nomenclatureId));

            return 1;
        }

        /** @var string $filename */
        $filename = $input->getArgument('filename');
        $file = new \SplFileObject($filename, 'r');

        $this->commandBus->handle(new NomenclatureImportCommand($nomenclature, $file));

        return 0;
    }
}
