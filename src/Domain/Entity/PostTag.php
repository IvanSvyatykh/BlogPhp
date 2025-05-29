<?php

namespace Pri301\Blog\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name: 'post_tags', schema: "public")]
#[ORM\UniqueConstraint(name: 'unique_tag_for_post', columns: ['tag_id', 'post_id'])]
class PostTag
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer', name: "Id", unique: true, nullable: false)]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Post::class)]
    #[ORM\JoinColumn(name: 'post_id', referencedColumnName: 'id', nullable: false)]
    private Post $post;

    #[ORM\ManyToOne(targetEntity: Tag::class)]
    #[ORM\JoinColumn(name: 'tag_id', referencedColumnName: 'id', nullable: false)]
    private Tag $tag;


    public function __construct(Post $post, Tag $tag)
    {
        $this->post = $post;
        $this->tag = $tag;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function getTag(): Tag
    {
        return $this->tag;
    }

    public function getId(): int
    {
        return $this->id;
    }

}