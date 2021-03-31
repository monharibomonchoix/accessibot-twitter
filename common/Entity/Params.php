<?php

namespace Database\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table("params")
*/
class Params
{
      /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int $id
     */
    protected int $id;

    /**
     * @ORM\Column(type="string")
     * @var string $param_name
     */
    protected string $param_name;

    /**
     * @ORM\Column(type="string")
     * @var string $param_value
     */
    protected string $param_value;

    /**
     * Get the parameter name
     * @return string
     */
    public function getParamName()
    {
      return $this->param_name;
    }

    /**
     * Set parameter name
     * @param string $param_name
     */
    public function setParamName(string $param_name)
    {
      $this->param_name = $param_name;
    }

    /**
     * Get the parameter value
     * @return string
     */
    public function getParamValue()
    {
       return $this->param_value;
    }

    /**
     * Set parameter value
     * @param string $param_value
     */
    public function setParamValue(string $param_value)
    {
      $this->param_value = $param_value;
    }
}