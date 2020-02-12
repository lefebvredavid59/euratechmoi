<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reserver;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Enfant", mappedBy="reservation")
     */
    private $enfants;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evenement", mappedBy="reservation")
     */
    private $evenement;

    public function __construct()
    {
        $this->enfants = new ArrayCollection();
        $this->evenement = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReserver(): ?int
    {
        return $this->reserver;
    }

    public function setReserver(?int $reserver): self
    {
        $this->reserver = $reserver;

        return $this;
    }

    /**
     * @return Collection|Enfant[]
     */
    public function getEnfants(): Collection
    {
        return $this->enfants;
    }

    public function addEnfant(Enfant $enfant): self
    {
        if (!$this->enfants->contains($enfant)) {
            $this->enfants[] = $enfant;
            $enfant->setReservation($this);
        }

        return $this;
    }

    public function removeEnfant(Enfant $enfant): self
    {
        if ($this->enfants->contains($enfant)) {
            $this->enfants->removeElement($enfant);
            // set the owning side to null (unless already changed)
            if ($enfant->getReservation() === $this) {
                $enfant->setReservation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenement(): Collection
    {
        return $this->evenement;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenement->contains($evenement)) {
            $this->evenement[] = $evenement;
            $evenement->setReservation($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenement->contains($evenement)) {
            $this->evenement->removeElement($evenement);
            // set the owning side to null (unless already changed)
            if ($evenement->getReservation() === $this) {
                $evenement->setReservation(null);
            }
        }

        return $this;
    }
}
