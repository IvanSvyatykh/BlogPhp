<?php
namespace Pri301\Blog\Enteties;

use Doctrine\ORM\Mapping as ORM;


#[Orm\Table(name: 'post_tags',schema: "public")]
class PostTag {

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer', unique: true)]
    private ?int $id = null;
    #[ORM\Column(type: 'string', length: 50, unique: true)]
    private ?string $tag = null;

    public function __construct(string $tag)
    {
        $this->$tag = $tag;
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