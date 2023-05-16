<?php

namespace App\Utils;

use App\Class\Comment;

class CommentManager
{
    private static $instance = null;
    private DB $db;

    private Comment $comment;
    private function __construct()
    {
        $this->db = DB::getInstance();
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    public function listComments()
    {
        $rows = $this->db->select('SELECT * FROM `comment`');

        $comments = [];
        foreach ($rows as $row) {
            $n = new Comment();
            $comments[] = $n->setId($row['id'])
                ->setBody($row['body'])
                ->setCreatedAt($row['created_at'])
                ->setNewsId($row['news_id']);
        }

        return $comments;
    }

    public function addCommentForNews($body, $newsId)
    {
        $sql = "INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES('" . $body . "','" . date('Y-m-d') . "','" . $newsId . "')";
        $this->db->exec($sql);
        return $this->db->lastInsertId($sql);
    }

    public function deleteComment($id)
    {
        $sql = "DELETE FROM `comment` WHERE `id`=" . $id;
        return $this->db->exec($sql);
    }
}