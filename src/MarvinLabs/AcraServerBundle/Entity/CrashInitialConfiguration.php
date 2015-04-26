<?php

namespace MarvinLabs\AcraServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crashes
 *
 * @ORM\Table(name="acra_crash_initial_configuration")
 * @ORM\Entity()
 *
 */
class CrashInitialConfiguration
{

	/**
	 * @ORM\ID
	 * @ORM\ManyToOne(targetEntity="MarvinLabs\AcraServerBundle\Entity\Crash")
	 * @ORM\JoinColumn(name="crash_id", referencedColumnName="id", nullable=false)
	 */
	private $crash;


    /**
     * @var string
     *
	 * @ORM\ID
     * @ORM\Column(name="key", type="string", nullable=false)
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text", nullable=false)
     */
    private $value;

	/**
	 * @return mixed
	 */
	public function getCrash()
	{
		return $this->crash;
	}

	/**
	 * @param mixed $crash
	 */
	public function setCrash($crash)
	{
		$this->crash = $crash;
	}

	/**
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @param string $key
	 */
	public function setKey($key)
	{
		$this->key = $key;
	}

	/**
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param string $value
	 */
	public function setValue($value)
	{
		$this->value = $value;
	}





}