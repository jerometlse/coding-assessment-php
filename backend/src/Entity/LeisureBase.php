<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=LeisureBaseRepository::class)
 */
class LeisureBase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"leisureBase_index", "leisurebase_create"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"leisureBase_index", "leisurebase_create"})
     * 
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"leisureBase_index", "leisurebase_create"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"leisureBase_index", "leisurebase_create"})
     */
    private $link;

    /**
     * @ORM\ManyToMany(targetEntity=ActivityCategory::class, inversedBy="leisureBases")
     * @Groups({"leisureBase_index"})
     * 
     */
    private $activityCategories;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"leisureBase_index", "leisurebase_create"})
     * 
     */
    private $address;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"leisureBase_index"})
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"leisureBase_index"})
     */
    private $longitude;

    /**
     * current wether of leisure base
     * @Groups({"leisureBase_index"})
     */
    private $currentWether;


    public function __construct()
    {
        $this->activityCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return Collection<int, ActivityCategory>
     */
    public function getactivityCategories(): Collection
    {
        return $this->activityCategories;
    }

    public function addActivityCategory(ActivityCategory $activityCategory): self
    {
        if (!$this->activityCategories->contains($activityCategory)) {
            $this->activityCategories[] = $activityCategory;
        }

        return $this;
    }

    public function removeActivityCategory(ActivityCategory $activityCategory): self
    {
        $this->activityCategories->removeElement($activityCategory);

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCurrentWether(): ?array
    {
        return $this->currentWether;
    }

    public function setCurrentWether(?array $currentWether): self
    {
        $this->currentWether = $currentWether;

        return $this;
    }

}
