<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Test;


use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Issue;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Bundle\FrameworkBundle\Console\Application;

class RegisterUserTest extends WebTestCase
{


	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $em;

	protected $application;

	/**
	 * {@inheritDoc}
	 */
	public function setUp()
	{
		static::$kernel = static::createKernel();
		static::$kernel->boot();
		$this->em = static::$kernel->getContainer()
			->get('doctrine')
			->getManager();

		$this->application = new Application(static::$kernel);
		$this->application->setAutoExit(false);
		$this->application->run(new StringInput('doctrine:schema:drop --force --quiet'));
		$this->application->run(new StringInput('doctrine:migrations:version  --no-interaction --delete --all --quiet'));
		$this->application->run(new StringInput('doctrine:migrations:migrate --no-interaction --quiet'));


	}

	public function testSearchByCategoryName()
	{


		$user = new User();
		$user->setEmail('test@example.com');
		$user->setPassword('oeuoeu');

		$this->em->persist($user);
		$this->em->flush();

		$userRepo = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:User');
		$user = $userRepo->find($user->getId());

		$this->assertEquals('test@example.com', $user->getEmail());


	}

	/**
	 * {@inheritDoc}
	 */
	protected function tearDown()
	{
		parent::tearDown();
		$this->em->close();
	}

}
