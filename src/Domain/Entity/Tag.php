<?php
namespace Pri301\Blog\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[Orm\Table(name: 'tags',schema: "public")]
class Tag {

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer', unique: true, nullable: false)]
    private int $id;
    #[ORM\Column(type: 'string', length: 50, unique: true,nullable: false)]
    private string $tag;

    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

}