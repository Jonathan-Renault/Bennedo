<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConsumerHasBin
 *
 * @ORM\Table(name="consumer_has_bin", indexes={@ORM\Index(name="IDX_EB430E02E218C269", columns={"id_report"}), @ORM\Index(name="IDX_EB430E022080DBB2", columns={"id_consumer"}), @ORM\Index(name="IDX_EB430E023483B2B7", columns={"id_bin"})})
 * @ORM\Entity
 */
class ConsumerHasBin
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="guid", nullable=false, options={"default"="uuid_generate_v1()"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="consumer_has_bin_id_seq", allocationSize=1, initialValue=1)
     */
    private $id = 'uuid_generate_v1()';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \Report
     *
     * @ORM\ManyToOne(targetEntity="Report")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_report", referencedColumnName="id")
     * })
     */
    private $idReport;

    /**
     * @var \Consumer
     *
     * @ORM\ManyToOne(targetEntity="Consumer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_consumer", referencedColumnName="id")
     * })
     */
    private $idConsumer;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIdReport(): ?Report
    {
        return $this->idReport;
    }

    public function setIdReport(?Report $idReport): self
    {
        $this->idReport = $idReport;

        return $this;
    }

    public function getIdConsumer(): ?Consumer
    {
        return $this->idConsumer;
    }

    public function setIdConsumer(?Consumer $idConsumer): self
    {
        $this->idConsumer = $idConsumer;

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
