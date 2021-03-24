<?php

class Conf
{
  /**
   * User ID to monitor
   * @var int $userId
   */
  private static $userId = -1;

  /**
   * Variable set to true one Init done
   * @var bool $isInitialized
   */
  private static $isInitialized = false;

  /**
   * PDO object to database connection.
   * @var \PDO $connection
   */
  private static PDO $connection;
  /**
   * API V1 key
   * @var string $twitterApiKey
   */
  private static string $twitterApiKey = "THIS MUST REMAIN SECRET";
  /**
   * API V1 secret key
   * @var string twitterApiSecretKey
   */
  private static string $twitterApiSecretKey = "THIS MUST REMAIN SECRET";
  /**
   * API V2 Bearer Token
   * @var string $BearerToken
   */
  private static string $BearerToken = "THIS MUST REMAIN SECRET";

  /**
   * Database version. Used to migrate versions.
   *  @var string $databaseVersion
   */
  private static string $databaseVersion = "0.1";

  /**
   * Get connection
   * @return \PDO
   */ 
  public static function getConnection()
  {
    return Conf::$connection;
  }

  /**
   * Get Twitter API V1 Key
   * @return string
   */
  public function getTwitterApiKey()
  {
    return Conf::$twitterApiKey;
  }

  /**
   * Get Twitter API V1 Secret Key
   * @return string
   */
  public function getTwitterApiSecretKey()
  {
    return Conf::$twitterApiSecretKey;
  }

  /**
   * Get initialization
   * @return bool
   */
  public static function getIsInitialized()
  {
    return Conf::$isInitialized;
  }

  /**
   * Get Bearer token (for V2 API)
   * @return string
   */
  public static function getBearerToken()
  {
    return Conf::$BearerToken;
  }

  /**
   * @return void
   */
  function Init()
  {
    $pdoString = "sqlite:" . dirname(__FILE__) . "/../database/accessibot-twitter.sqlite3";
    
    if (Conf::$isInitialized == false)
    {
      try
      {
        Conf::$connection = new PDO($pdoString);
        Conf::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        Conf::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      catch(Exception $e)
      {
        $message = "Can't open database : ".$e->getMessage();
        die($message);
      }
      Conf::$isInitialized = true;

      Database::Update();
    }
  }
}

?>
