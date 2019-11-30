<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consumer
 *
 * @ORM\Table(name="consumer", indexes={@ORM\Index(name="IDX_705B37274E1F76F3", columns={"id_closest_bin"})})
 * @ORM\Entity
 */
class Consumer
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="guid", nullable=false, options={"default"="uuid_generate_v1()"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="consumer_id_seq", allocationSize=1, initialValue=1)
     */
    private $id = 'uuid_generate_v1()';

    /**
     * @var geography|null
     *
     * @ORM\Column(name="coords", type="geography", nullable=true)
     */
    private $coords;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=255, nullable=false)
     */
    private $ipAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="device", type="string", length=100, nullable=false)
     */
    private $device;

    /**
     * @var string
     *
     * @ORM\Column(name="navigator", type="string", length=100, nullable=false)
     */
    private $navigator;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \Bin
     *
     * @ORM\ManyToOne(targetEntity="Bin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_closest_bin", referencedColumnName="id")
     * })
     */
    private $idClosestBin;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCoords()
    {
        return $this->coords;
    }

    public function setCoords($coords): self
    {
        $this->coords = $coords;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function getDevice(): ?string
    {
        return $this->device;
    }

    public function setDevice(string $device): self
    {
        $this->device = $device;

        return $this;
    }

    public function getNavigator(): ?string
    {
        return $this->navigator;
    }

    public function setNavigator(string $navigator): self
    {
        $this->navigator = $navigator;

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

    public function getIdClosestBin(): ?Bin
    {
        return $this->idClosestBin;
    }

    public function setIdClosestBin(?Bin $idClosestBin): self
    {
        $this->idClosestBin = $idClosestBin;

        return $this;
    }


}
