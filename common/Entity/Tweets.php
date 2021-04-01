<?php

namespace Database\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table("tweets")
*/
class Tweets
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   * @var int $id
   */
  
   protected int $id;
  /**
   * @ORM\Column(type="bigint")
   * @var int $id
   */
  protected int $tweet_id;

  /**
   * @ORM\Column(type="datetime")
   * @var DateTime $fetched_date
   */
  protected DateTime $fetched_date;

  /**
   * @ORM\Column(type="boolean")
   * @var bool $done
   */
  protected bool $done = false;

  /**
   * @ORM\Column(type="boolean")
   * @var bool $forwarded
   */
  protected bool $forwarded = false;

  /**
   * Get tweet internal ID
   * @return int
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Get tweet ID
   * @return int
   */
  public function getTweetId()
  {
    return $this->tweet_id;
  }

  /**
   * Set tweet internal ID
   * @param int $id
   * @return void
   */
  public function setTweetId(int $tweet_id)
  {
    $this->tweet_id = $tweet_id;
  }

  /**
   * Get tweet fetched date
   * @return DateTime
   */
  public function getFetchedDate()
  {
    return $this->fetched_date;
  }

  /**
   * Set tweet fetched time
   * @param DateTime $fetched_date
   * @return void
   */
  public function setFetchedDate(DateTime $fetched_date)
  {
    $this->fetched_date = $fetched_date;
  }

  /**
   * Get tweet is done translated
   * @return bool
   */
  public function getDone()
  {
    return $this->done;
  }

  /**
   * Set tweet done translated
   * @param bool $done
   * @return void
   */
  public function setDone(bool $done)
  {
    $this->done = $done;
  }

  /**
   * Get Tweet has been forwarded
   * @return bool
   */
  public function getForwarded()
  {
    return $this->forwarded;
  }

  /**
   * Set Tweet has been forwarded
   * @param bool $forwarded
   * @return void
   */
  public function setForwarded(bool $forwarded)
  {
    $this->forwarded = $forwarded;
  }
}