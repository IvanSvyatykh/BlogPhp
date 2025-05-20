<?php
namespace Pri301\Blog\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name: 'post_tags',schema: "public")]
#[ORM\UniqueConstraint(name: 'unique_tag_for_post', columns: ['tag_id', 'post_id'])]
class PostTags
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer',name: "Id", unique: true)]
    private ?int $id;

    #[ORM\OneToOne(targetEntity: Post::class)]
    #[ORM\Column(type: 'integer', name: 'post_id')]
    #[ORM\JoinColumn(name: 'post_id', referencedColumnName: 'id',nullable: false)]
    private Post $post;

    #[ORM\OneToOne(targetEntity: Tag::class)]
    #[ORM\Column(type: 'integer', name: 'tag_id')]
    #[ORM\JoinColumn(name: 'tag_id', referencedColumnName: 'id',nullable: false)]
    private Tag $tag;


    public function __construct(Post $post, Tag $tag){
        $this->post = $post;
        $this->tag = $tag;
    }

    public function getPost(): Post{
        return $this->post;
    }

    public function getTag(): Tag{
        return $this->tag;
    }

}