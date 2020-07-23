<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeRepository::class)
 * @Vich\Uploadable
 */
class Type
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3,max=15, minMessage="3 caractères minimum", maxMessage="15 caractères maximum")
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

      /**
     * @Vich\UploadableField(mapping="type_image", fileNameProperty="image")
     */
    private $imageFile;

    /**
     * @ORM\OneToMany(targetEntity=Aliment::class, mappedBy="type")
     */
    private $aliments;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

        /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): self
    {
        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile)
        {
            $this->updated_at = new \DateTime('now');
        }

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function __construct()
    {
        $this->aliments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Aliment[]
     */
    public function getAliments(): Collection
    {
        return $this->aliments;
    }

    public function addAliment(Aliment $aliment): self
    {
        if (!$this->aliments->contains($aliment)) {
            $this->aliments[] = $aliment;
            $aliment->setType($this);
        }

        return $this;
    }

    public function removeAliment(Aliment $aliment): self
    {
        if ($this->aliments->contains($aliment)) {
            $this->aliments->removeElement($aliment);
            // set the owning side to null (unless already changed)
            if ($aliment->getType() === $this) {
                $aliment->setType(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
