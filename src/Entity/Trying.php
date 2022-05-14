<?php

namespace App\Entity;

use App\Repository\TryingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TryingRepository::class)]
class Trying
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $swifty;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSwifty(): ?string
    {
        return $this->swifty;
    }

    public function setSwifty(string $swifty): self
    {
        $this->swifty = $swifty;

        return $this;
    }
}
