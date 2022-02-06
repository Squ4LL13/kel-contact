<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ContactRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

$classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
#[UniqueEntity(
    fields: ['name'],
    message: 'Ce contact existe déjà.'
)]
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(["contact:read", "category:read"])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[
        Assert\NotBlank(
            message: 'Ce champ ne peut être vide.'
        ),
        Assert\NotNull(
            message: 'Ce champ ne peut être vide.'
        ),
        Groups(["contact:read", "category:read", "meet:read"])
    ]
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(["contact:read", "category:read", "meet:read"])]
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(["contact:read", "category:read", "meet:read"])]
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(["contact:read", "category:read", "meet:read"])]
    private $service;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(["contact:read", "category:read", "meet:read"])]
    private $company;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[
        Assert\Regex(
            pattern: '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',
            message: '{{ value }} n\'est pas un email valide.'
        ),
        Groups(["contact:read", "category:read", "meet:read"])
    ]
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[
        Assert\Regex(
            pattern: '/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/',
            message: 'Numéro de téléphone invalide : ex. 04 00 00 00 00'
        ),
        Groups(["contact:read", "category:read", "meet:read"])
    ]
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[
        Assert\Regex(
            pattern: '/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[6-7](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/',
            message: 'Numéro de portable invalide : ex. 06 00 00 00 00'
        ),
        Groups(["contact:read", "category:read", "meet:read"])
    ]
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(["contact:read", "category:read", "meet:read"])]
    private $address;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    #[Groups(["contact:read", "category:read", "meet:read"])]
    private $note;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(["contact:read", "category:read", "meet:read"])]
    private $storagePlace;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(["contact:read", "category:read", "meet:read"])]
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    #[Groups(["contact:read", "category:read", "meet:read"])]
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="contacts")
     */
    #[Groups("contact:read", "meet:read")]
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(["contact:read", "category:read", "meet:read"])]
    private $link;

    /**
     * @ORM\ManyToOne(targetEntity=LetterCategory::class, inversedBy="contacts")
     * @ORM\JoinColumn(nullable=true)
     */
    private $letterCategory;

    /**
     * @ORM\OneToMany(targetEntity=Meet::class, mappedBy="contact", orphanRemoval=true)
     */
    private $meets;
    
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->meets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(?string $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getStoragePlace(): ?string
    {
        return $this->storagePlace;
    }

    public function setStoragePlace(?string $storagePlace): self
    {
        $this->storagePlace = $storagePlace;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getLetterCategory(): ?LetterCategory
    {
        return $this->letterCategory;
    }

    public function setLetterCategory(?LetterCategory $letterCategory): self
    {
        $this->letterCategory = $letterCategory;
        return $this;
    }

    /**
     * @return Collection|Meet[]
     */
    public function getMeets(): Collection
    {
        return $this->meets;
    }

    public function addMeet(Meet $meet): self
    {
        if (!$this->meets->contains($meet)) {
            $this->meets[] = $meet;
            $meet->setContact($this);
        }

        return $this;
    }

    public function removeMeet(Meet $meet): self
    {
        if ($this->meets->removeElement($meet)) {
            // set the owning side to null (unless already changed)
            if ($meet->getContact() === $this) {
                $meet->setContact(null);
            }
        }

        return $this;
    }
}
