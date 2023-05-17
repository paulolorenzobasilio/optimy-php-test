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

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;}

    public function getTitle()
    {
        return $this->title;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
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
