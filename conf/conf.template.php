<?php

class Conf
{
  /**
   * Doctrine parameters to connect database
   */
  private static $dbParams = [
    "driver"   => "pdo_sqlite",
    "path"     => __DIR__ . "/database/accessibot-twitter.sqlite3"
  ];

  /**
   * Conversation ID for PMs
   * @var int
   */
  private static $convId = -1;

  /**
   * Twitter access token
   */
  private static $accessToken = "THIS MUST BE KEPT SECRET";

  /**
   * Twitter access secret token
   */
  private static $accessTokenSecret = "THIS MUST BE KEPT SECRET";

  /**
   * User ID to monitor
   * @var int $userId
   */
  private static $userId = -1;

  /**
   * User TN to monitor
   * @var string $userTN
   */

  private static $userTN = "@YOUR_TN";

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
   * @return array
   */ 
  public static function GetConnection()
  {
    return Conf::$dbParams;
  }

  /**
   * Get Twitter API V1 Key
   * @return string
   */
  public function GetTwitterApiKey()
  {
    return Conf::$twitterApiKey;
  }

  /**
   * Get Twitter API V1 Secret Key
   * @return string
   */
  public function GetTwitterApiSecretKey()
  {
    return Conf::$twitterApiSecretKey;
  }

  /**
   * Get initialization
   * @return bool
   */
  public static function GetIsInitialized()
  {
    return Conf::$isInitialized;
  }

  /**
   * Get Bearer token (for V2 API)
   * @return string
   */
  public static function GetBearerToken()
  {
    return Conf::$BearerToken;
  }

  /**
   * Get the user ID of monitored user
   * @return int
   */

  public static function GetUserId()
  {
    return Conf::$userId;
  }

  /**
   * Get the user TN of monitored user
   * @return int
   */

  public static function GetUserTN()
  {
    return Conf::$userTN;
  }

  /**
   * Get the message ID of PMs
   * @return int
   */

  public static function GetConvId()
  {
    return Conf::$convId;
  }

  /**
   * Get the access token for V1.1 Twitter API
   * @return string
   */

  public static function GetAccessToken()
  {
    return Conf::$accessToken;
  }

  /**
   * Get the access secret token for V1.1 Twitter API
   * @return string
   */

  public static function GetAccessTokenSecret()
  {
    return Conf::$accessTokenSecret;
  }
}

