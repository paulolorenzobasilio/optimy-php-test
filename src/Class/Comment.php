<?php

namespace App\Class;

use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Column;

#[Entity]
class Comment
{

    #[Column(type: "primary")]
    private int $id;
    #[Column(type: "string")]
    private string $body;
    #[Column(type: 'datetime')]
    private \DateTime $createdAt;
    #[Column(type: "string")]
    private string $newsId;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
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

    public function getNewsId()
    {
        return $this->newsId;
    }

    public function setNewsId($newsId)
    {
        $this->newsId = $newsId;

        return $this;
    }
}
