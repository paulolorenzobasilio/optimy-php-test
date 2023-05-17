<?php

namespace App\Utils;

use App\Class\Comment;
use App\Class\News;
use Cycle\ORM\EntityManagerInterface;
use Cycle\ORM\ORM;
use Cycle\ORM\ORMInterface;

class CommentManager
{
    public function __construct(private ORMInterface $orm, private EntityManagerInterface $em)
    {
    }

    public function listComments()
    {
        return $this->orm->getRepository(Comment::class)->findAll();
    }

    public function addCommentForNews(string $body, int $newsId): Comment
    {
        $comment = new Comment();
        $comment->setNewsId($newsId);
        $comment->setBody($body);
        $comment->setCreatedAt(new \DateTimeImmutable());

        $this->em->persist($comment);
        $this->em->run();

        return $comment;
    }

    public function deleteComment(int $id): void
    {
        $comment = $this->orm->getRepository(Comment::class)->findByPK($id);
        $this->em->delete($comment);
        $this->em->run();
    }
}
