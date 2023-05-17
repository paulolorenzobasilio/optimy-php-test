<?php

namespace App\Class;

use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Relation\HasMany;

#[Entity]
class News
{
    #[Column(type: 'primary')]
    private int $id;
    #[Column(type: 'string')]
    private string $title;
    #[Column(type: 'string')]
    private string $body;
    #[Column(type: 'datetime')]
    private \DateTimeImmutable $createdAt;
    #[HasMany(target: Comment::class)]
    private ?array $comments;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getComments(): ?array
    {
        return $this->comments;
    }
}
