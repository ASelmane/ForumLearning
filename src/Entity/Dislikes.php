<?php

namespace App\Entity;

use App\Repository\DislikesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DislikesRepository::class)
 */
class Dislikes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Topics::class, inversedBy="dislikes")
     */
    private $topic;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="dislikes")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTopic(): ?Topics
    {
        return $this->topic;
    }

    public function setTopic(?Topics $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }
}
