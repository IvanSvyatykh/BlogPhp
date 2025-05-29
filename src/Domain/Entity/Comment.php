<?php

namespace Pri301\Blog\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'comments', schema: "public")]
class Comment
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer', unique: true)]
    private ?int $id;
    #[ORM\Column(type: 'string', length: 50)]
    private string $content;
    #[ORM\ManyToOne(targetEntity: Post::class)]
    #[ORM\JoinColumn(name: 'post_id', referencedColumnName: 'id', nullable: false)]
    private ?Post $post = null;
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private ?User $author = null;
    #[ORM\Column(type: 'datetime', name: 'created_at')]
    private \DateTime $createdAt;


    public function __construct(
        string $content,
        Post $post,
        User $author,
    ) {
        $this->content = $content;
        $this->post = $post;
        $this->author = $author;
        $this->createdAt = new \DateTime();
    }

    // Getters and setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    public function setPost(Post $post): void
    {
        $this->post = $post;
    }
}