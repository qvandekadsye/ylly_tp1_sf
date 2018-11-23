<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TranslateEntityCommand extends Command
{
    protected function configure()
    {
        $this
            ->addOption(
                'targetLanguages',
                'l',
                InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL,
                'Target languages to be use separated by spaces',
                ['fr', 'es', 'it', 'de']
            )
            ->addOption(
                'entities',
                'ent',
                InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL,
                'Entites to be translated seperated by space'
            )
            ->addUsage('--l=fr es --ent=blocks');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output); // TODO: Change the autogenerated stub
    }
}