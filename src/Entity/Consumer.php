<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConsumerRepository")
 */
class Consumer
{
    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="geography", nullable=true, options={"geometry_type"="POINT"})
     */
    private $coords;

    /**
     * @ORM\Column(type="string")
     */
    private $ip_address;

    /**
     * @ORM\Column(type="uuid")
     */
    private $id_closest_bin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $device;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $navigator;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ConsumerHasBin", mappedBy="id_consumer")
     */
    private $id_consumer;

    public function __construct()
    {
        $this->id_consumer = new ArrayCollection();
        $this->id = Uuid::uuid4();
        $this->created_at = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
    }

    public function getId()
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

    public function getIdClosestBin()
    {
        return $this->id_closest_bin;
    }

    public function setIdClosestBin($id_closest_bin): self
    {
        $this->id_closest_bin = $id_closest_bin;

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
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|ConsumerHasBin[]
     */
    public function getIdConsumer(): Collection
    {
        return $this->id_consumer;
    }

    public function addIdConsumer(ConsumerHasBin $idConsumer): self
    {
        if (!$this->id_consumer->contains($idConsumer)) {
            $this->id_consumer[] = $idConsumer;
            $idConsumer->setIdConsumer($this);
        }

        return $this;
    }

    public function removeIdConsumer(ConsumerHasBin $idConsumer): self
    {
        if ($this->id_consumer->contains($idConsumer)) {
            $this->id_consumer->removeElement($idConsumer);
            // set the owning side to null (unless already changed)
            if ($idConsumer->getIdConsumer() === $this) {
                $idConsumer->setIdConsumer(null);
            }
        }

        return $this;
    }
}
