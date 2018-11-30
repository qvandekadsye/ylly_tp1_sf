<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Locale.
 *
 * @ORM\Table(name="locale")
 * @ORM\Entity()
 */
class Locale
{
    /**
     * @var string
     * @ORM\Column(name="code", type="string", length=10)
     * @ORM\Id()
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column(name="languageUsed", type="string", length=10, nullable=false, options={"default": "en"})
     */
    protected $targetLanguage;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTargetLanguage()
    {
        return $this->targetLanguage;
    }

    /**
     * @param string $targetLanguage
     */
    public function setTargetLanguage($targetLanguage)
    {
        $this->targetLanguage = $targetLanguage;
    }
}
