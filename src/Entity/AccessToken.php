<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class AccessToken
{
    /**
     * @var Uuid $id
     */
    #[ORM\Id, ORM\Column(type: "uuid"), ORM\GeneratedValue]
    private Uuid $id;

    #[ORM\Column(type: "text")]
    private string $name;

    #[ORM\Column(type: "text")]
    private string $token;

    #[ORM\Column(type: "boolean")]
    private bool $valid = false;

    public function __construct() {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): void
    {
        $this->valid = $valid;
    }

}