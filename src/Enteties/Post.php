<?php

namespace Pri301\Blog\Enteties;

use Doctrine\ORM\Mapping as ORM;


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
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $author;
    #[ORM\Column(type: 'datetime', name: 'created_at')]
    private \DateTime $createdAt;
    #[ORM\Column(type: 'bool' )]
    private bool $isPublished = false;
    #[ORM\OneToOne(targetEntity: PostStatus::class)]
    #[ORM\JoinColumn(name: 'status_id', referencedColumnName: 'id')]
    private PostStatus $status;
    #[ORM\OneToOne(targetEntity: PostType::class)]
    #[ORM\JoinColumn(name:'post_type_id', referencedColumnName: 'id')]
    private PostType $type;
    #[ORM\OneToMany(targetEntity: PostTag::class)]
    #[ORM\JoinColumn(name: 'post_tags', referencedColumnName: 'id')]
    private PostTag $tag;

    public function __construct(
        string $title,
        string $content,
        User $author,
        ?\DateTime $createdAt = null,
        PostStatus $status,
        PostType $type,
        PostTag $tag
    ) {
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->createdAt = $createdAt ?? new \DateTime();
        $this->status = $status;
        $this->type = $type;
        $this->tag = $tag;
    }

    // Getters and setters
    public function getId(): ?int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getContent(): string { return $this->content; }
    public function getCreatedAt(): \DateTime { return $this->createdAt; }
    public function getAuthor(): ?User { return $this->author; }
    public function getStatus(): PostStatus { return $this->status; }
    public function getType(): PostType { return $this->type; }
    public function getTag(): PostTag { return $this->tag; }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    public function setContent(string $content): void{
        $this->content = $content;
    }

    public function setStatus(PostStatus $status): void{
        $this->status = $status;
    }
    public function setType(PostType $type): void{

        $this->type = $type;
    }
    public function setTag(PostTag $tag): void{
        $this->tag = $tag;
    }
    public function setAuthor(User $author): void { $this->author = $author; }
    public function isPublished(): bool { return $this->isPublished; }
    public function setPublished(bool $value): void { $this->isPublished = $value; }

}