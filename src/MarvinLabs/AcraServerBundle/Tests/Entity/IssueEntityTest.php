<?php

namespace MarvinLabs\AcraServerBundle\Test\Entity;


use MarvinLabs\AcraServerBundle\Entity\Crash;
use MarvinLabs\AcraServerBundle\Entity\Issue;

class IssueEntityTest extends \PHPUnit_Framework_TestCase
{

	public function dataForSetTitleFromCrash() {
		return array(
			array('','Issue'),
			array('         ','Issue'),
			array('java.lang.RuntimeException: getImageThumbnailCallbacks onLoadFinished() called & was success
	at com.niceagain.beecount.ui.BasePictureActivity$1.onLoadFinished(BasePictureActivity.java:167)','java.lang.RuntimeException: getImageThumbnailCallbacks onLoadFinished() called & was success'),
		);
	}

	/**
	 * @dataProvider dataForSetTitleFromCrash
	 */
	public function testSetTitleFromCrash($in, $out) {
		$crash = new Crash();
		$crash->setStackTrace($in);
		$issue = new Issue();
		$issue->setTitleFromCrash($crash);
		$this->assertEquals($out, $issue->getTitle());
	}

}


