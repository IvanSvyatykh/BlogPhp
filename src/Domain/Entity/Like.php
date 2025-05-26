<?php

namespace Pri301\Blog\Domain\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'likes',schema: "public")]
#[ORM\UniqueConstraint(name: 'unique_likes', columns: ['user_id', 'post_id'])]
class Like
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer', unique: true)]
    private int $id;

    #[ORM\OneToOne(targetEntity: Post::class)]
    #[ORM\JoinColumn(name: 'post_id', referencedColumnName: 'id',nullable: false)]
    private Post $post;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id',nullable: false)]
    private User $user;

    #[ORM\Column(type: 'datetime', name: 'created_at')]
    private \DateTime $createdAt;

    public function __construct(
        Post $post,
        User $user
    ) {
        $this->post = $post;
        $this->user = $user;
        $this->createdAt = new \DateTime();
    }

    // Getters
    public function getPost(): Post { return $this->post; }
    public function getUser(): User { return $this->user; }
    public function getCreatedAt(): \DateTime { return $this->createdAt; }
}