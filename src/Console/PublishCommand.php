<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Console;

use Headsnet\LivingDocumentationBundle\Services\AttributeLoader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'headsnet:livedoc:publish', description: 'Publish documentation')]
class PublishCommand extends Command
{
    public function __construct(
        private readonly AttributeLoader $parser
    ) {
        parent::__construct();
    }

    #[\Override]
    protected function configure(): void
    {
        $this
            ->addArgument(
                'namespace',
                InputArgument::REQUIRED,
                'The namespace to process'
            )
            ->addOption(
                'context',
                'c',
                InputOption::VALUE_REQUIRED,
                'What is the name of the context?',
                'default'
            )
            ->addOption(
                'output',
                'o',
                InputOption::VALUE_REQUIRED,
                'Path to output directory',
                'docs/'
            )
        ;
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->parser->load(
            $input->getArgument('namespace'),
            $input->getOption('context'),
            $input->getOption('output')
        );

        return Command::SUCCESS;
    }
}
