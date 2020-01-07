<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConsumerHasBinRepository")
 */
class ConsumerHasBin
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
     * @ORM\Column(type="string", length=255)
     */
    private $action;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bin", inversedBy="id_bin")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_bin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Consumer", inversedBy="id_consumer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_consumer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Report", inversedBy="id_consumer_has_bin")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_report;

    public function getId()
    {
        return $this->id;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

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

    public function getIdBin(): ?Bin
    {
        return $this->id_bin;
    }

    public function setIdBin(?Bin $id_bin): self
    {
        $this->id_bin = $id_bin;

        return $this;
    }

    public function getIdConsumer(): ?Consumer
    {
        return $this->id_consumer;
    }

    public function setIdConsumer(?Consumer $id_consumer): self
    {
        $this->id_consumer = $id_consumer;

        return $this;
    }

    public function getIdReport(): ?Report
    {
        return $this->id_report;
    }

    public function setIdReport(?Report $id_report): self
    {
        $this->id_report = $id_report;

        return $this;
    }
}
