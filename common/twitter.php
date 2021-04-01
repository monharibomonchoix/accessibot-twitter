<?php
  use \Abraham\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuth as TwitterOAuthTwitterOAuth;

class Twitter
  {
    /**
     * Get messages from tweeter
     * @return json
     */

    public static function GetMessages()
    {
      $startTime = null;

      $entityManager = require(__DIR__ . "/bootstrap.php");
      $paramsRepo = $entityManager->getRepository(\Database\Entity\Params::class);
      $startTimeObject = $paramsRepo->findOneBy([ "param_name" => "twitter_start_time" ]);

      if($startTimeObject != null)
      {
        $startTime = $startTimeObject->getParamValue();
      }

      if ($startTime != null)
      {
        $startTime = "&start_time=" . $startTime;
      }
      else
      {
        $startTime = "";
      }

      $url = "https://api.twitter.com/2/users/" . Conf::GetUserId() . "/mentions?max_results=100&media.fields=type&tweet.fields=attachments,id,text,created_at,author_id,in_reply_to_user_id" . $startTime;

      $ch = curl_init();
      $headers = array("Authorization: Bearer " . Conf::GetBearerToken());

      $options = array(
        CURLOPT_URL            => $url,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true
      );
      curl_setopt_array($ch, $options);

      $json = json_decode(curl_exec($ch), true);
      curl_close($ch);

      return $json;
    }

    /**
     * Send MP to conversation
     * @return bool
     */

    public static function Retweet($id)
    {
      $twitterConnection = new TwitterOAuthTwitterOAuth(Conf::GetTwitterApiKey(), Conf::GetTwitterApiSecretKey(), Conf::GetAccessToken(), Conf::GetAccessTokenSecret());
      $params = [ ];

      $content = $twitterConnection->post("statuses/retweet/" . $id, $params, true);

      return ($twitterConnection->getLastHttpCode() == 200);
    }

    /**
     * Send MP to conversation
     * @return bool
     */

    public static function UnRetweet($id)
    {
      $twitterConnection = new TwitterOAuthTwitterOAuth(Conf::GetTwitterApiKey(), Conf::GetTwitterApiSecretKey(), Conf::GetAccessToken(), Conf::GetAccessTokenSecret());
      $params = [ ];

      $content = $twitterConnection->post("statuses/unretweet/" . $id, $params, true);

      return ($twitterConnection->getLastHttpCode() == 200);
    }
  }
