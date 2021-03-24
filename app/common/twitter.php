<?php
  class Twitter
  {
    public static function getMessages()
    {
      $startTime = Database::getParam("curl_start_time");
      if ($startTime != null)
      {
        $startTime = "&start_time=" . $startTime;
      }
      else
      {
        $startTime = "";
      }

      $url = "https://api.twitter.com/2/users/1113490271768068097/mentions?max_results=100&media.fields=type&tweet.fields=attachments,id,text,source" . $startTime;

      $ch = curl_init($url);
      $headers = array(
                        "Accept: application/json",
                        "Content-Type: application/json",
                        "Authorization: Bearer AAAAAAAAAAAAAAAAAAAAAI2fNwEAAAAA2L0vtatJ1rdCsbCGVhawM5KTGhE%3DfN0F61Mr8yeo0aOXaC3KyhRt7YIPYXqL7OgGBXvhTr1E6qGqid"
                      );
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      $json = curl_exec($ch);
      curl_close($ch);
      die();
    }
  }
