<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Test\CrashACRA;


use JMBTechnology\BrokenOpenAppCoreBundle\Entity\IncomingCrashACRA;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Project;
use JMBTechnology\BrokenOpenAppCoreBundle\Test\BaseTestWithDataBase;

include_once(__DIR__."/../BaseTestWithDataBase.php");

class NoStacktraceCrashTest extends BaseTestWithDataBase
{



	public function testStackTraceOnly1()
	{

		// Set up DB
		$project = new Project();
		$project->setTitle("Test");

		$incomingCrashACRA = new IncomingCrashACRA();
		$incomingCrashACRA->setProject($project);
		$incomingCrashACRA->setIncomingCrashKey("test");

		$this->em->persist($project);
		$this->em->persist($incomingCrashACRA);
		$this->em->flush();


		// Run Request!
		$client = static::createClient();

		$crawler = $client->request("POST","/incomingcrashacra?project=test",array(
		));

		$this->assertTrue($client->getResponse()->isSuccessful());

		// Load Crash from DB and check!

		$crash = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Crash')->findOneBy(array('project'=>$project));

		$this->assertNull($crash);


	}



}
