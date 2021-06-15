<?php

namespace App\Entity;

use App\Repository\PropertyAuditRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PropertyAuditRepository::class)
 */
class PropertyAudit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $entityClass;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $propertyName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $oldValue;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $newValue;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityClass(): ?string
    {
        return $this->entityClass;
    }

    public function setEntityClass(?string $entityClass): self
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    public function getPropertyName(): ?string
    {
        return $this->propertyName;
    }

    public function setPropertyName(?string $propertyName): self
    {
        $this->propertyName = $propertyName;

        return $this;
    }

    public function getOldValue(): ?string
    {
        return $this->oldValue;
    }

    public function setOldValue(?string $oldValue): self
    {
        $this->oldValue = $oldValue;

        return $this;
    }

    public function getNewValue(): ?string
    {
        return $this->newValue;
    }

    public function setNewValue(?string $newValue): self
    {
        $this->newValue = $newValue;

        return $this;
    }

    public function getTs(): ?\DateTimeInterface
    {
        return $this->ts;
    }

    public function setTs(?\DateTimeInterface $ts): self
    {
        $this->ts = $ts;

        return $this;
    }
}
