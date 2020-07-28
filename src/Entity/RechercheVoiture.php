<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;


class RechercheVoiture
{
    /**
     * @Assert\LessThanOrEqual(propertyPath="maxAnnee", message="doit être plus petit que l'année max")
     */
    private $minAnnee;

    /**
     * @Assert\GreaterThanOrEqual(propertyPath="minAnnee", message="doit être plus grand que l'année min")
     */
    private $maxAnnee;


    public function getMinAnnee()
    {
        return $this->minAnnee;
    }

    public function getMaxAnnee()
    {
        return $this->maxAnnee;
    }

    public function setMinAnnee(int $minAnnee)
    {
        $this->minAnnee = $minAnnee;
    }

    public function setMaxAnnee(int $maxAnnee)
    {
        $this->maxAnnee = $maxAnnee;
    }
}