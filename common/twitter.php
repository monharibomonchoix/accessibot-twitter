<?php
  class Twitter
  {
    /**
     * Get messages from tweeter
     * @return json
     */

    public static function getMessages()
    {
      $startTime = Database::getParam("twitter_start_time");
      if ($startTime != null)
      {
        $startTime = "&start_time=" . $startTime;
      }
      else
      {
        $startTime = "";
      }

      $url = "https://api.twitter.com/2/users/" . Conf::getUserId() . "/mentions?max_results=100&media.fields=type&tweet.fields=attachments,id,text,created_at" . $startTime;

      $ch = curl_init();
      $headers = array("Authorization: Bearer " . Conf::getBearerToken());

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
  }
