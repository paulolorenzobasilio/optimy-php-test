<?php

namespace App\Utils;

use App\Class\News;
use Cycle\ORM\EntityManagerInterface;
use Cycle\ORM\ORMInterface;

class NewsManager
{
    public function __construct(private CommentManager $commentManager,
                                private ORMInterface $orm,
                                private EntityManagerInterface $em)
    {
    }

    /**
     * list all news
     */
    public function listNews()
    {
        return $this->orm->getRepository(News::class)->findAll();
    }

    /**
     * add a record in news table
     */
    public function addNews(string $title, string $body): News
    {
        $news = new News();
        $news->setTitle($title);
        $news->setBody($body);
        $news->setCreatedAt(new \DateTimeImmutable());

        $this->em->persist($news);
        $this->em->run();

        return $news;
    }

    /**
     * deletes a news, and also linked comments
     */
    public function deleteNews($id): void
    {
        $comments = $this->commentManager->listComments();
        $idsToDelete = [];

        foreach ($comments as $comment) {
            if ($comment->getNewsId() == $id) {
                $idsToDelete[] = $comment->getId();
            }
        }

        foreach ($idsToDelete as $id) {
            $this->commentManager->deleteComment($id);
        }

        $news = $this->orm->getRepository(News::class)->findByPK($id);
        $this->em->delete($news);
        $this->em->run();
    }
}
