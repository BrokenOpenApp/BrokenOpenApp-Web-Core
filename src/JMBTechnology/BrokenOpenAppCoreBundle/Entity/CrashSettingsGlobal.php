<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crashes Settings Global
 *
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 *
 * @ORM\Table(name="acra_crash_settings_global")
 * @ORM\Entity()
 *
 */
class CrashSettingsGlobal
{

	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash")
	 * @ORM\JoinColumn(name="crash_id", referencedColumnName="id", nullable=false)
	 */
	private $crash;


    /**
     * @var string
     *
	 * @ORM\Id
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