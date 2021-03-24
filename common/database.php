<?php

class Database
{
  /**
   * Get value of given param
   * @param string $paramName Name of the param in database
   * @return string param value
   */
  static function getParam(string $paramName)
  {
    if (Conf::getIsInitialized() == false)
    {
      die("Please initialize configuration before calling Database functions");
    }
    $pdo = Conf::getConnection();

    $query = $pdo->prepare("SELECT param_value FROM params WHERE param_name = :paramName;");
    $query->execute(array("paramName" => "$paramName"));
    $paramValue = $query->fetch(PDO::FETCH_OBJ);
    return $paramValue->param_value;
  }

  /**
   * Update database to latest version.
   * @return void
   */
  static function Update()
  {
    $pdo = Conf::getConnection();

    $query = $pdo->exec("CREATE TABLE IF NOT EXISTS params (param_name VARCHAR(50) PRIMARY  KEY, param_value VARCHAR(50));");
    $version = Database::getParam("TWITTER_DATABASE_VERSION");
    if ($version == null)
    {
      $query = $pdo->exec("CREATE TABLE IF NOT EXISTS tweets (id BIGINT NOT NULL PRIMARY KEY, fetched_date DATETIME, done INT, forwarded INT);");

      Database::UpdateParam("TWITTER_DATABASE_VERSION", "0.1");
    }
  }

  /**
   * Insert tweet for treatment
   * @param int $id ID of tweet
   * @param string $created_at Creation date of the tweet (ISO 8601)
   * @return void
   */
  static function InsertTweet(int $id, string $created_at)
  {
    $pdo = Conf::getConnection();
    $params = array(
      "id" => $id
    );

    $query = $pdo->prepare("SELECT COUNT(id) AS nbTweet FROM tweets WHERE id = :id;");
    $query->execute($params);
    $data = $query->fetch();
    if ($data["nbTweet"] == 0)
    {   
      $query = $pdo->prepare("INSERT INTO tweets (id, fetched_date, done, forwarded) VALUES (:id, :created_at, 0, 0)");
      $params["created_at"] = $created_at;

      try
      {
        $query->execute($params);
      }
      catch (Exception $e)
      {
        LogMessage::log("Error inserting tweet " . $id . " in database. Continuing anyway.", MESSAGE_LOG_WARNING);
        LogMessage::log("". $e->getMessage(), MESSAGE_LOG_WARNING);
      }
    }
    else
    {
      LogMessage::log("Tweet " . $id . " already in database. Ignoring.", MESSAGE_LOG_INFO);
    }
  }

  /**
   * Update given param in database
   * @param string $paramName Name of the param. Must be unique (will be errased)
   * @param string $paramValue Value of param
   * @return void
   */

  static function UpdateParam(string $paramName, string $paramValue)
  {
    $pdo = Conf::getConnection();
    
    $params = array(
      "paramName" => $paramName
    );

    LogMessage::log("Set parameter: " . $paramName . " => " . $paramValue);

    $query = $pdo->prepare("DELETE FROM params WHERE param_name = :paramName");
    $query->execute($params);
    $query = $pdo->prepare("INSERT INTO params (param_name, param_value) VALUES (:paramName, :paramValue);");
    $params["paramValue"] = $paramValue;
    $query->execute($params);
  }
}
