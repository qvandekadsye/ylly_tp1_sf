<?php

namespace AppBundle\Service;

use Google\Cloud\Translate\TranslateClient;

class GoogleTranslateService
{
    const LENGTHLIMIT = 2000;
    /**
     * @var TranslateClient
     */
    protected $translateClient;

    public function __construct($apikey)
    {
        $this->translateClient = new TranslateClient(['apikey' => $apikey]);
    }

    /**
     * @param $sourceLanguage
     * @param $targetLanguage
     * @param $toBeTranslated
     *
     * @return string
     */
    public function translate($sourceLanguage, $targetLanguage, $toBeTranslated)
    {
        try {
            if (mb_strlen($toBeTranslated, 'UTF8') >= self::LENGTHLIMIT) {
                $parts = str_split($toBeTranslated, self::LENGTHLIMIT);
                $translatedArray = [];
                foreach ($parts as $part) {
                    $translatedArray[] = $this->translate($sourceLanguage, $targetLanguage, $part);
                }

                return implode('', $translatedArray);
            }

            return $this->translateClient->translate($toBeTranslated, ['source' => $sourceLanguage, 'target' => $targetLanguage])['text'];
        } catch (\Exception $exception) {
            //todo  à voir en fonction de l'exception;
            return 'toto';
        }
    }

    /**
     * @param $sourceLanguage
     * @param $targetLanguage
     * @param $toBeTranslatedArray
     *
     * @return array
     */
    public function translateBatch($sourceLanguage, $targetLanguage, $toBeTranslatedArray)
    {
        $filteredArray = array_filter($toBeTranslatedArray);
        $translatedArray = [];
        foreach ($filteredArray as $key => $value) {
            $translatedArray[$key] = $this->translate($sourceLanguage, $targetLanguage, $value);
        }

        return $translatedArray;
    }
}
