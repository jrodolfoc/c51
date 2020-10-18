<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="offer")
 *
 * Defines the structure of an offer
 *
 * @author Jose Calvo <jrodolfoc@gmail.com>
 */
class Offer
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $offer_id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $image_url;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $cash_back;

    public function getOfferId(): ?int
    {
        return $this->offer_id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    /**
     * @param string $image_url
     */
    public function setImageUrl(string $image_url): void
    {
        $this->image_url = $image_url;
    }

    /**
     * @return float
     */
    public function getCashBack(): ?float
    {
        return $this->cash_back;
    }

    /**
     * @param float $cash_back
     */
    public function setCashBack(float $cash_back): void
    {
        $this->cash_back = $cash_back;
    }
}
