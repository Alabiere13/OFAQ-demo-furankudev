<?php

namespace App\Entity;

use DateTime;
use Serializable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="user")
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="user")
     */
    private $answers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VoteForQuestion", mappedBy="user")
     */
    private $voteForQuestions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VoteForAnswer", mappedBy="user")
     */
    private $voteForAnswers;

    public function __construct()
    {
        $this->isActive = true;
        $this->createdAt = new DateTime();
        $this->questions = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->voteForQuestions = new ArrayCollection();
        $this->voteForAnswers = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->username;
    }

    public function fakerConstruct()
    {
        $this->questions = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->voteForQuestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
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

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setUser($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getUser() === $this) {
                $question->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setUser($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getUser() === $this) {
                $answer->setUser(null);
            }
        }

        return $this;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles()
    {
        return [$this->getRole()->getCode()];
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ]);
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    /**
     * @return Collection|VoteForQuestion[]
     */
    public function getVoteForQuestions(): Collection
    {
        return $this->voteForQuestions;
    }

    public function addVoteForQuestion(VoteForQuestion $voteForQuestion): self
    {
        if (!$this->voteForQuestions->contains($voteForQuestion)) {
            $this->voteForQuestions[] = $voteForQuestion;
            $voteForQuestion->setUser($this);
        }

        return $this;
    }

    public function removeVoteForQuestion(VoteForQuestion $voteForQuestion): self
    {
        if ($this->voteForQuestions->contains($voteForQuestion)) {
            $this->voteForQuestions->removeElement($voteForQuestion);
            // set the owning side to null (unless already changed)
            if ($voteForQuestion->getUser() === $this) {
                $voteForQuestion->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VoteForAnswer[]
     */
    public function getVoteForAnswers(): Collection
    {
        return $this->voteForAnswers;
    }

    public function addVoteForAnswer(VoteForAnswer $voteForAnswer): self
    {
        if (!$this->voteForAnswers->contains($voteForAnswer)) {
            $this->voteForAnswers[] = $voteForAnswer;
            $voteForAnswer->setUser($this);
        }

        return $this;
    }

    public function removeVoteForAnswer(VoteForAnswer $voteForAnswer): self
    {
        if ($this->voteForAnswers->contains($voteForAnswer)) {
            $this->voteForAnswers->removeElement($voteForAnswer);
            // set the owning side to null (unless already changed)
            if ($voteForAnswer->getUser() === $this) {
                $voteForAnswer->setUser(null);
            }
        }

        return $this;
    }

}
