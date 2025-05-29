<?php

namespace Pri301\Blog\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'post_types', schema: "public")]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer', unique: true)]
    private int $id;

    #[ORM\Column(type: 'string', length: 50)]
    private string $type;


    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

}