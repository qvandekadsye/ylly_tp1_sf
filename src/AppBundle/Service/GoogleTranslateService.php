<?php

namespace AppBundle\Service;

use AppBundle\Interfaces\TranslatorInterface;
use Google\Cloud\Translate\TranslateClient;

class GoogleTranslateService implements TranslatorInterface
{
    const LENGTHLIMIT = 1000;
    /**
     * @var TranslateClient
     */
    protected $translateClient;

    public function __construct($apikey)
    {
        $this->translateClient = new TranslateClient(['key' => $apikey]);
        var_dump($apikey);
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
            $errorArray = json_decode($exception->getMessage());
            if($errorArray->message === "User Rate Limit Exceeded")
            {
                var_dump( $exception->getMessage());
                sleep(100);
            }


            return $this->translateClient->translate($toBeTranslated, ['source' => $sourceLanguage, 'target' => $targetLanguage])['text'];
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
