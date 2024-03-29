<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ActivityCategoryRepository::class)
 */
class ActivityCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"activityCategory_index","leisureBase_index"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"activityCategory_index","leisureBase_index"})
     */
    private $label;

    /**
     * @ORM\ManyToMany(targetEntity=LeisureBase::class, mappedBy="activityCategories")
     */
    private $leisureBases;

    public function __construct()
    {
        $this->leisureBases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, LeisureBase>
     */
    public function getLeisureBases(): Collection
    {
        return $this->leisureBases;
    }

    public function addLeisureBasis(LeisureBase $leisureBasis): self
    {
        if (!$this->leisureBases->contains($leisureBasis)) {
            $this->leisureBases[] = $leisureBasis;
            $leisureBasis->addActivityCategory($this);
        }

        return $this;
    }

    public function removeLeisureBasis(LeisureBase $leisureBasis): self
    {
        if ($this->leisureBases->removeElement($leisureBasis)) {
            $leisureBasis->removeActivityCategory($this);
        }

        return $this;
    }
}
