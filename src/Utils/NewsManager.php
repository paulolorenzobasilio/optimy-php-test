<?php

namespace App\Utils;

use App\Class\News;

class NewsManager
{
    private News $news;

    public function __construct(private CommentManager $commentManager, private DB $db)
    {
    }

    /**
     * list all news
     */
    public function listNews()
    {
        $rows = $this->db->select('SELECT * FROM `news`');

        $news = [];
        foreach ($rows as $row) {
            $n = new News();
            $news[] = $n->setId($row['id'])
                ->setTitle($row['title'])
                ->setBody($row['body'])
                ->setCreatedAt($row['created_at']);
        }

        return $news;
    }

    /**
     * add a record in news table
     */
    public function addNews($title, $body)
    {
        $sql = "INSERT INTO `news` (`title`, `body`, `created_at`) VALUES('" . $title . "','" . $body . "','" . date('Y-m-d') . "')";
        $this->db->exec($sql);
        return $this->db->lastInsertId($sql);
    }

    /**
     * deletes a news, and also linked comments
     */
    public function deleteNews($id)
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


        $sql = "DELETE FROM `news` WHERE `id`=" . $id;
        return $this->db->exec($sql);
    }
}
