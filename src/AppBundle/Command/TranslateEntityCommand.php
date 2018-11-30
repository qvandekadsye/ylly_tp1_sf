<?php

namespace AppBundle\Command;

use AppBundle\Interfaces\TranslationsManagerInterface;
use AppBundle\Service\EntityTranslationService;
use AppBundle\Service\KnpTranslationManagerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TranslateEntityCommand extends Command
{
    /**
     * @var TranslationsManagerInterface
     */
    protected $entityTranslationService;

    public function __construct(KnpTranslationManagerService $entityTranslationService, $name = null)
    {
        $this->entityTranslationService =$entityTranslationService;
        parent::__construct($name);
    }


    protected function configure()
    {
        $this
            ->setName("ylly:translate")
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
        $languages = $input->getOption('targetLanguages');
        $entities = $input->getOption('entities');

        $output->writeln('<info>Start</info>');

        foreach ($entities as $entity) {
            $output->writeln("<info>Currently translating: ". $entity."</info>");
            $result = call_user_func([$this->entityTranslationService, "manage"], $entity,'en','fr');
            if ($result) {
                $output->writeln("<info>OK</info>");
            } else {
                $output->writeln("<error>Not OK</error>");
            }
        }
        $output->writeln('<info>End</info>');
    }
}
