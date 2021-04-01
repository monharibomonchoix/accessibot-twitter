<?php
  function stop()
  {
    http_response_code(500);
    exit(1);
  }

  isset($_GET["tweet_id"]) or stop();
  is_numeric($_GET["tweet_id"]) or stop();

  require_once (__DIR__ . "/../conf/conf.php");
  require_once (__DIR__ . "/../common/twitter.php");
  require_once (__DIR__ . "/../common/log.php");
  require_once (__DIR__ . "/../vendor/autoload.php");

  $entityManager = require(__DIR__ . "/../common/bootstrap.php");

  $tweetsRepo = $entityManager->getRepository(\Database\Entity\Tweets::class);

  $tweet_internal_id = (int)$_GET["tweet_id"];

  $tweet = $tweetsRepo->find($tweet_internal_id);

  if ($tweet == null)
  {
    stop();
  }
  
  if (Twitter::UnRetweet($tweet->getTweetId()))
  {
    $tweet->setDone(true);
    $entityManager->flush();
    echo $tweet_internal_id;
  }
