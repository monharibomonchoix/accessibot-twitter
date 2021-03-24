<?php
  require_once(dirname(__FILE__) . "/../conf/conf.php");
  require_once(dirname(__FILE__) . "/../common/database.php");
  require_once(dirname(__FILE__) . "/../common/twitter.php");
  require_once(dirname(__FILE__) . "/../common/log.php");

  Conf::Init();

  $tweets = Twitter::getMessages();

  $added = 0;

  if(isset($tweets["data"]) == true)
  {
    foreach($tweets["data"] as $key => $tweet)
    {
      ++$added;
      Database::InsertTweet($tweet["id"], $tweet["created_at"]);
    }
    LogMessage::log($added . " tweets added.", MESSAGE_LOG_INFO);
  }

  Database::UpdateParam("twitter_start_time", date('Y-m-d\TH:i:s\Z'));