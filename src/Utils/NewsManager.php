<?php

namespace App\Utils;

use App\Class\News;

class NewsManager
{
    private static $instance = null;

    private DB $db;
    private CommentManager $commentManager;
    private News $news;

    private function __construct()
    {
        $this->db = DB::getInstance();
        $this->commentManager = CommentManager::getInstance();
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
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
