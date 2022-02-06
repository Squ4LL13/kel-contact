<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MeetRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MeetRepository::class)
 */
class Meet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['meet:read', 'contact:read'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['meet:read', 'contact:read'])]
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(['meet:read', 'contact:read'])]
    private $meetingStart;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(['meet:read', 'contact:read'])]
    private $meetingEnd;

    /**
     * @ORM\ManyToOne(targetEntity=Contact::class, inversedBy="meets")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['meet:read'])]
    private $contact;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getMeetingStart(): ?\DateTimeInterface
    {
        return $this->meetingStart;
    }

    public function setMeetingStart(\DateTimeInterface $meetingStart): self
    {
        $this->meetingStart = $meetingStart;

        return $this;
    }

    public function getMeetingEnd(): ?\DateTimeInterface
    {
        return $this->meetingEnd;
    }

    public function setMeetingEnd(\DateTimeInterface $meetingEnd): self
    {
        $this->meetingEnd = $meetingEnd;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
