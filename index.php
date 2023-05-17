<?php

require 'vendor/autoload.php';

use App\Utils\NewsManager;
use App\Utils\CommentManager;

$container = new \DI\Container();

$newsManager = $container->get(NewsManager::class);
$commentManager = $container->get(CommentManager::class);

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
