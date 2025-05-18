<?php

namespace Pri301\Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'posts',schema: "public")]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer',name: "Id", unique: true)]
    private ?int $id;
    #[ORM\Column(type: 'string', length: 50)]
    private string $title;
    #[ORM\Column(type: 'string')]
    private string $content;
    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $author;
    #[ORM\Column(type: 'datetime', name: 'created_at')]
    private \DateTime $createdAt;
    #[ORM\Column(type: 'boolean' )]
    private bool $isPublished = false;
    #[ORM\OneToOne(targetEntity: Status::class)]
    #[ORM\JoinColumn(name: 'status_id', referencedColumnName: 'id')]
    private Status $status;
    #[ORM\OneToOne(targetEntity: Type::class)]
    #[ORM\JoinColumn(name:'post_type_id', referencedColumnName: 'id')]
    private Type $type;

    public function __construct(
        string     $title,
        string     $content,
        User       $author,
        ?\DateTime $createdAt = null,
        Status     $status,
        Type       $type,
    ) {
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->createdAt = $createdAt ?? new \DateTime();
        $this->status = $status;
        $this->type = $type;
    }

    // Getters and setters
    public function getId(): ?int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getContent(): string { return $this->content; }
    public function getCreatedAt(): \DateTime { return $this->createdAt; }
    public function getAuthor(): ?User { return $this->author; }
    public function getStatus(): Status { return $this->status; }
    public function getType(): Type { return $this->type; }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    public function setContent(string $content): void{
        $this->content = $content;
    }

    public function setStatus(Status $status): void{
        $this->status = $status;
    }
    public function setType(Type $type): void{

        $this->type = $type;
    }
    public function setAuthor(User $author): void { $this->author = $author; }
    public function isPublished(): bool { return $this->isPublished; }
    public function setPublished(bool $value): void { $this->isPublished = $value; }

}