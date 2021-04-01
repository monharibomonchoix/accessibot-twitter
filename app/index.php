<?php
  require_once(__DIR__ . "/../conf/conf.php");
  require_once(__DIR__ . "/../vendor/autoload.php");
  require_once(__DIR__ . "/../common/log.php");

  $entityManager = require(__DIR__ . "/../common/bootstrap.php");

  $tweetsRepo = $entityManager->getRepository(\Database\Entity\Tweets::class);
  $paramsRepo = $entityManager->getRepository(\Database\Entity\Params::class);

?><!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Accessi bot - Awaiting tweets</title>
  <meta name="description" content="Awaiting to be translated tweets">
  <meta name="author" content="Sylvain RUMEU">
  <meta name="twitter:widgets:theme" content="light">
  <meta name="twitter:widgets:border-color" content="#55acee">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6"
        crossorigin="anonymous"></head>
  <script src="https://platform.twitter.com/widgets.js"></script>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
          crossorigin="anonymous">
  </script>
  <script async
    custom-element="amp-twitter"
    src="https://cdn.ampproject.org/v0/amp-twitter-0.1.js">
</script>

<script>
  function setDone(id)
  {
    req = new XMLHttpRequest();
    req.onreadystatechange = function()
      {
        if (req.readyState == 4) 
        { 
          if(req.status  == 200) 
          {
            tr = window.document.getElementById("tr_" + req.responseText);
            tr.parentNode.removeChild(tr);
          }
          else 
          {
            alert("Erreur\n" + req.responseText);
          }
        }
      };
   
    req.open("GET", "ajax.php?tweet_id=" + id,  true); 
    req.send(null); 
  }
</script>

  <div>
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">id</th>
          <th scope="col">tweet</th>
          <th scope="col"><span role="img" aria-label="Set done">✅</span></th>
        </tr>
      </thead>
      <tbody>
<?php

  $awaitingTweets = $tweetsRepo->findBy([ "done" => 0 ]);


  foreach ($awaitingTweets as $current_tweet)
  {
    echo "<tr id=\"tr_" . $current_tweet->getId() . "\"><th scope=\"row\">" . $current_tweet->getTweetId() . "</th>";
    echo "<td><amp-twitter data-tweetid=\"" . $current_tweet->getTweetId() . "\" layout=\"responsive\"></td>";
    echo "<td><button type=\"button\" class=\"btn btn-success\" onclick=\"javascript:setDone(" . $current_tweet->getId() . ")\">✅</button></td>";
  }
?>
      </tbody>
    </table>
  </div>
</body>
</html>
