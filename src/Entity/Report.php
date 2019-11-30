<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Report
 *
 * @ORM\Table(name="report", indexes={@ORM\Index(name="IDX_C42F77843483B2B7", columns={"id_bin"})})
 * @ORM\Entity
 */
class Report
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="guid", nullable=false, options={"default"="uuid_generate_v1()"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="report_id_seq", allocationSize=1, initialValue=1)
     */
    private $id = 'uuid_generate_v1()';

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=100, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=100, nullable=false)
     */
    private $status;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="time_resolved", type="datetime", nullable=true)
     */
    private $timeResolved;

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

    /**
     * @var \Bin
     *
     * @ORM\ManyToOne(targetEntity="Bin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bin", referencedColumnName="id")
     * })
     */
    private $idBin;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTimeResolved(): ?\DateTimeInterface
    {
        return $this->timeResolved;
    }

    public function setTimeResolved(?\DateTimeInterface $timeResolved): self
    {
        $this->timeResolved = $timeResolved;

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

    public function getIdBin(): ?Bin
    {
        return $this->idBin;
    }

    public function setIdBin(?Bin $idBin): self
    {
        $this->idBin = $idBin;

        return $this;
    }


}
