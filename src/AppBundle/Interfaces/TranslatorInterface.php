<?php

namespace AppBundle\Interfaces;

interface TranslatorInterface
{
    /**
     * @param $sourceLanguage string
     * @param $targetLanguage string
     * @param $toBeTranslated string
     * @return string
     */
    public function translate($sourceLanguage, $targetLanguage, $toBeTranslated );

    /**
     * @param $sourceLanguage
     * @param $targetLanguage
     * @param $toBeTranslatedArray
     *
     * @return array
     */
    public function translateBatch($sourceLanguage, $targetLanguage, $toBeTranslatedArray);
}