<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Test\CrashACRA;


use JMBTechnology\BrokenOpenAppCoreBundle\Entity\IncomingCrashACRA;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Project;
use JMBTechnology\BrokenOpenAppCoreBundle\Test\BaseTestWithDataBase;

include_once(__DIR__."/../BaseTestWithDataBase.php");

class MinimalCrashTest extends BaseTestWithDataBase
{


    function dataForTestStackTraceOnly1() {
        return array(
            array("/incomingcrashacra?project=test"),
            array("/incomingcrashacra?key=test"),
        );
    }

    /**
     * @dataProvider dataForTestStackTraceOnly1
     */
	public function testStackTraceOnly1($url)
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

		$crawler = $client->request("POST",$url,array(
			'STACK_TRACE'=>'12345',
		));

		$this->assertTrue($client->getResponse()->isSuccessful());

		// Load Crash from DB and check!

		$crash = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Crash')->findOneBy(array('project'=>$project));

		$this->assertNotNull($crash);
		$this->assertEquals("12345", $crash->getStackTrace());



	}



}
