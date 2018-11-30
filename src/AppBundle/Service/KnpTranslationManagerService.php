<?php

namespace AppBundle\Service;

use AppBundle\Entity\Article;
use AppBundle\Entity\ArticleBis;
use AppBundle\Entity\ArticleTer;
use AppBundle\Entity\Block;
use AppBundle\Entity\BlockBis;
use AppBundle\Entity\BlockTer;
use AppBundle\Entity\Dog;
use AppBundle\Entity\Kitten;
use AppBundle\Interfaces\TranslationsManagerInterface;
use AppBundle\Interfaces\TranslatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionClass;

class KnpTranslationManagerService implements TranslationsManagerInterface
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * EntityTranslationService constructor.
     *
     * @param TranslatorInterface $translator
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(TranslatorInterface $translator, EntityManagerInterface $entityManager)
    {
        $this->translator = $translator;
        $this->entityManager = $entityManager;
    }

    public function manage($className, $sourceLanguage, $targetLanguage)
    {
        try {
            $reflectionClass = new ReflectionClass("AppBundle\Entity\\".$className."Translation");
            $reflectionClassMother = new ReflectionClass("AppBundle\Entity\\".$className);
            $collection = $this->entityManager->getRepository($reflectionClassMother->getName())->findAll();
            $properties = $reflectionClass->getProperties(\ReflectionMethod::IS_PRIVATE);
            foreach ($collection as $item) {
                foreach ($properties as $property) {
                    $data = $item->translate($sourceLanguage)->{'get'.ucfirst($property->getName())}();
                    $translation = $this->translator->translate($sourceLanguage, $targetLanguage, $data);
                    $item->translate($targetLanguage, false)->{'set'.ucfirst($property->getName())}($translation);
                }
                $this->entityManager->persist($item);
                $item->mergeNewTranslations();
            }
            $this->entityManager->flush();

        } catch (\ReflectionException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $sourceLanguage
     * @param $animal Dog | Kitten
     *
     * @return array
     */
    private function getAnimalData($sourceLanguage, $animal)
    {
        return [
            'race' => $animal->translate($sourceLanguage)->getRace(),
            'desc' => $animal->translate($sourceLanguage)->getDescription(),
        ];
    }

    /**
     * @param $sourceLanguage
     * @param $page
     *
     * @return array
     */
    private function getPageData($sourceLanguage, $page)
    {
        return [
            'title' => $page->translate($sourceLanguage)->getTitle(),
            'content' => $page->translate($sourceLanguage)->getContent(),
            'subtitle' => $page->translate($sourceLanguage)->getSubtitle(),
        ];
    }

    /**
     * @param $sourceLanguage
     * @param $article Article | ArticleBis | ArticleTer
     *
     * @return array
     */
    private function getArticleData($sourceLanguage, $article)
    {
        return
        [
            'title' => $article->translate($sourceLanguage)->getTitle(),
            'content' => $article->translate($sourceLanguage)->getContent(),
        ];
    }

    /**
     * @param $sourceLanguage
     * @param $block Block | BlockBis | BlockTer
     *
     * @return array
     */
    private function getBlockData($sourceLanguage, $block)
    {
        return
            [
                'title' => $block->translate($sourceLanguage)->getTitle(),
                'content' => $block->translate($sourceLanguage)->getContent(),
            ];
    }
}
