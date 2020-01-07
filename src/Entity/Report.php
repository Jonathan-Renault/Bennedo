<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReportRepository")
 */
class Report
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
     * @ORM\OneToMany(targetEntity="App\Entity\ConsumerHasBin", mappedBy="id_report")
     */
    private $id_consumer_has_bin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AdminHasReport", mappedBy="id_report")
     */
    private $id_admin_has_report;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $time_resolved;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    public function __construct()
    {
        $this->id_consumer_has_bin = new ArrayCollection();
        $this->id_admin_has_report = new ArrayCollection();
        $this->id = Uuid::uuid4();
        $this->created_at = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection|ConsumerHasBin[]
     */
    public function getIdConsumerHasBin(): Collection
    {
        return $this->id_consumer_has_bin;
    }

    public function addIdConsumerHasBin(ConsumerHasBin $idConsumerHasBin): self
    {
        if (!$this->id_consumer_has_bin->contains($idConsumerHasBin)) {
            $this->id_consumer_has_bin[] = $idConsumerHasBin;
            $idConsumerHasBin->setIdReport($this);
        }

        return $this;
    }

    public function removeIdConsumerHasBin(ConsumerHasBin $idConsumerHasBin): self
    {
        if ($this->id_consumer_has_bin->contains($idConsumerHasBin)) {
            $this->id_consumer_has_bin->removeElement($idConsumerHasBin);
            // set the owning side to null (unless already changed)
            if ($idConsumerHasBin->getIdReport() === $this) {
                $idConsumerHasBin->setIdReport(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AdminHasReport[]
     */
    public function getIdAdminHasReport(): Collection
    {
        return $this->id_admin_has_report;
    }

    public function addIdAdminHasReport(AdminHasReport $idAdminHasReport): self
    {
        if (!$this->id_admin_has_report->contains($idAdminHasReport)) {
            $this->id_admin_has_report[] = $idAdminHasReport;
            $idAdminHasReport->setIdReport($this);
        }

        return $this;
    }

    public function removeIdAdminHasReport(AdminHasReport $idAdminHasReport): self
    {
        if ($this->id_admin_has_report->contains($idAdminHasReport)) {
            $this->id_admin_has_report->removeElement($idAdminHasReport);
            // set the owning side to null (unless already changed)
            if ($idAdminHasReport->getIdReport() === $this) {
                $idAdminHasReport->setIdReport(null);
            }
        }

        return $this;
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
        return $this->time_resolved;
    }

    public function setTimeResolved(?\DateTimeInterface $time_resolved): self
    {
        $this->time_resolved = $time_resolved;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
