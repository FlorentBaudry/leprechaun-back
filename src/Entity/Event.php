<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $end_date;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'participations')]
    private $participations;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'event')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\OneToOne(mappedBy: 'event', targetEntity: Moneypot::class, cascade: ['persist', 'remove'])]
    private $moneypot;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'creations')]
    #[ORM\JoinColumn(nullable: false)]
    private $creation;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(?\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(User $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations[] = $participation;
        }

        return $this;
    }

    public function removeParticipation(User $participation): self
    {
        $this->participations->removeElement($participation);

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

    public function getMoneypot(): ?Moneypot
    {
        return $this->moneypot;
    }

    public function setMoneypot(Moneypot $moneypot): self
    {
        // set the owning side of the relation if necessary
        if ($moneypot->getEvent() !== $this) {
            $moneypot->setEvent($this);
        }

        $this->moneypot = $moneypot;

        return $this;
    }

    public function getCreation(): ?User
    {
        return $this->creation;
    }

    public function setCreation(?User $creation): self
    {
        $this->creation = $creation;

        return $this;
    }
}
