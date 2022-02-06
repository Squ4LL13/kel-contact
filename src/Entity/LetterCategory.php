<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\LetterCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LetterCategoryRepository::class)
 */
class LetterCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(["letterCategory:read", "contact:read"])]
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     */
    #[Groups(["letterCategory:read", "contact:read"])]
    private $letter;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="letterCategory")
     * @ORM\OrderBy({"name"="ASC"})
     */
    #[Groups(["letterCategory:read"])]
    private $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLetter(): ?string
    {
        return $this->letter;
    }

    public function setLetter(string $letter): self
    {
        $this->letter = $letter;

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setLetterCategory($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getLetterCategory() === $this) {
                $contact->setLetterCategory(null);
            }
        }

        return $this;
    }
}
