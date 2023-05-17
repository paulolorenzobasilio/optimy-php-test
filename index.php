<?php

require 'vendor/autoload.php';

$bootstrap = require 'bootstrap.php';

use App\Utils\NewsManager;
use App\Utils\CommentManager;

$newsManager = $bootstrap['container']->get(NewsManager::class);
$commentManager = $bootstrap['container']->get(CommentManager::class);

foreach ($newsManager->listNews() as $news) {
	echo("############ NEWS " . $news->getTitle() . " ############\n");
	echo($news->getBody() . "\n");
	foreach ($news->getComments() as $comment) {
        echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
	}
}
