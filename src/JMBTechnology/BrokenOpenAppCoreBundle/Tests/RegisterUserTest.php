<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Test;


use JMBTechnology\BrokenOpenAppCoreBundle\Entity\User;

include_once(__DIR__."/BaseTestWithDataBase.php");

class RegisterUserTest extends BaseTestWithDataBase
{

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


}
