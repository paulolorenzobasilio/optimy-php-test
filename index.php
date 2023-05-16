<?php

require 'vendor/autoload.php';

use App\Utils\NewsManager;
use App\Utils\CommentManager;

$newsManager = NewsManager::getInstance();
$commentManager = CommentManager::getInstance();

foreach ($newsManager->listNews() as $news) {
	echo("############ NEWS " . $news->getTitle() . " ############\n");
	echo($news->getBody() . "\n");
	foreach ($commentManager->listComments() as $comment) {
		if ($comment->getNewsId() == $news->getId()) {
			echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
		}
	}
}

$c = $commentManager->listComments();
