<?php

namespace Pri301\Blog\Enteties;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'user',schema: "public")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type:"string", length:255,nullable:false)]
    private $name;

    #[ORM\Column(type:"string", length:255,unique: true,nullable:false)]
    private $login;

    #[ORM\Column(type:"string", length:255,nullable:false)]
    private $password;

    #[ORM\Column(type:"boolean", name:'is_admin',nullable:false)]
    private $isAdmin = false;

    #[ORM\Column(type:"boolean", name:'is_moderator',nullable:false)]
    private $isModerator = false;

    #[ORM\Column(type:"datetime", name: 'created_at',nullable:false)]
    private $createdAt;


    public function __construct(string $name,string $login,string $password)
    {
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
        $this->createdAt = new \DateTime();;
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

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

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

    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getIsModerator(): ?bool
    {
        return $this->isModerator;
    }

    public function setIsModerator(bool $isModerator): self
    {
        $this->isModerator = $isModerator;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

}