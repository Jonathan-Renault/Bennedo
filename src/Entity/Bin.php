<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bin
 *
 * @ORM\Table(name="bin")
 * @ORM\Entity
 */
class Bin
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="guid", nullable=false, options={"default"="uuid_generate_v1()"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="bin_id_seq", allocationSize=1, initialValue=1)
     */
    private $id = 'uuid_generate_v1()';

    /**
     * @var geography
     *
     * @ORM\Column(name="coord", type="geography", nullable=false)
     */
    private $coord;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=false)
     */
    private $city;

    /**
     * @var int
     *
     * @ORM\Column(name="city_code", type="integer", nullable=false)
     */
    private $cityCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCoord()
    {
        return $this->coord;
    }

    public function setCoord($coord): self
    {
        $this->coord = $coord;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCityCode(): ?int
    {
        return $this->cityCode;
    }

    public function setCityCode(int $cityCode): self
    {
        $this->cityCode = $cityCode;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


}
