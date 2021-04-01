<?php
  require_once (__DIR__ . "/../conf/conf.php");
  require_once (__DIR__ . "/../common/twitter.php");
  require_once (__DIR__ . "/../common/log.php");
  require_once (__DIR__ . "/../vendor/autoload.php");

  $entityManager = require(__DIR__ . "/../common/bootstrap.php");

  $tweetsRepo = $entityManager->getRepository(\Database\Entity\Tweets::class);
  $paramsRepo = $entityManager->getRepository(\Database\Entity\Params::class);

  $added = 0;

  // Get all messages

  $tweets = Twitter::GetMessages();

  if(isset($tweets["data"]) == true)
  {
    foreach($tweets["data"] as $key => $tweet)
    {
      // Don't retweet your own tweet
      if ($tweet["author_id"] != Conf::GetUserId() && $tweet["in_reply_to_user_id"] != Conf::GetUserId())
      {
        ++$added;
        $new_tweet = new \Database\Entity\Tweets();
        $new_tweet->setTweetId($tweet["id"]);
        $new_tweet->setFetchedDate(date_create($tweet["created_at"]));

        $entityManager->persist($new_tweet);
      }
    }
    $entityManager->flush();
    LogMessage::Log($added . " tweets added.", MESSAGE_LOG_INFO);
  }

  $twitter_start_time = $paramsRepo->findOneBy(["param_name" => "twitter_start_time"]);

  if ($twitter_start_time == null)
  {
    $twitter_start_time = new \Database\Entity\Params();
    $twitter_start_time->setParamName("twitter_start_time");
  }
  $twitter_start_time->setParamValue(date('Y-m-d\TH:i:s\Z'));
  $entityManager->persist($twitter_start_time);
  $entityManager->flush();

  $awaitingTweets = $tweetsRepo->findBy([ "forwarded" => false ]);

  $retweeted = 0;

  // Sending retweets
  foreach ($awaitingTweets as $current_tweet)
  {
    if (Twitter::Retweet($current_tweet->getTweetId()) == true)
    {
      ++$retweeted;
      $current_tweet->setForwarded(true);
      $entityManager->persist($current_tweet);
    }
  }

  if ($retweeted > 0)
  {
    LogMessage::Log($retweeted . " tweets retweeted.", MESSAGE_LOG_INFO);
  }
  $twitter_start_time->setParamValue(date('Y-m-d\TH:i:s\Z'));
  $entityManager->persist($twitter_start_time);
  $entityManager->flush();

  $awaitingTweets = $tweetsRepo->findBy([ "forwarded" => false ]);

  $retweeted = 0;

  // Sending retweets
  foreach ($awaitingTweets as $current_tweet)
  {
    if (Twitter::Retweet($current_tweet->getId()) == true)
    {
      ++$retweeted;
      $current_tweet->setForwarded(true);
      $entityManager->persist($current_tweet);
    }
  }

  LogMessage::Log($retweeted . " tweets retweeted.", MESSAGE_LOG_INFO);

  $entityManager->flush();
