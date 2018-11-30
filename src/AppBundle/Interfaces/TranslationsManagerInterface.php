<?php


namespace AppBundle\Interfaces;


interface TranslationsManagerInterface
{
    public function manage($classname, $sourceLanguage, $targetLanguage);
}