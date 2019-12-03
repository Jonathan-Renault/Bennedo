<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminHasReportRepository")
 */
class AdminHasReport
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
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Report", inversedBy="id_admin_has_report")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_report;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin", inversedBy="id_admin_has_report")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_admin;

    public function getId()
    {
        return $this->id;
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

    public function getIdReport(): ?Report
    {
        return $this->id_report;
    }

    public function setIdReport(?Report $id_report): self
    {
        $this->id_report = $id_report;

        return $this;
    }

    public function getIdAdmin(): ?Admin
    {
        return $this->id_admin;
    }

    public function setIdAdmin(?Admin $id_admin): self
    {
        $this->id_admin = $id_admin;

        return $this;
    }
}
