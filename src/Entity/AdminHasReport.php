<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdminHasReport
 *
 * @ORM\Table(name="admin_has_report", indexes={@ORM\Index(name="IDX_2033C69AE218C269", columns={"id_report"}), @ORM\Index(name="IDX_2033C69A668B4C46", columns={"id_admin"})})
 * @ORM\Entity
 */
class AdminHasReport
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="guid", nullable=false, options={"default"="uuid_generate_v1()"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="admin_has_report_id_seq", allocationSize=1, initialValue=1)
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
     * @var \Admin
     *
     * @ORM\ManyToOne(targetEntity="Admin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_admin", referencedColumnName="id")
     * })
     */
    private $idAdmin;

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

    public function getIdAdmin(): ?Admin
    {
        return $this->idAdmin;
    }

    public function setIdAdmin(?Admin $idAdmin): self
    {
        $this->idAdmin = $idAdmin;

        return $this;
    }


}
