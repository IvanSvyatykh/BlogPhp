<?php

namespace Pri301\Blog\Enteties;

use Doctrine\ORM\Mapping as ORM;


#[Orm\Table(name: 'post_statuses',schema: "public")]
class PostStatus {

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer', unique: true)]
    private ?int $id = null;
    #[ORM\Column(type: 'string', length: 50, unique: true)]
    private ?string $status = null;

    public function __construct(string $status)
    {
        $this->$status = $status;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

}