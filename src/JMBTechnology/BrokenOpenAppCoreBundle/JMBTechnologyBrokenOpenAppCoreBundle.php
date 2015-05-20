<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class JMBTechnologyBrokenOpenAppCoreBundle extends Bundle
{



	static function createRandomString($minLength = 10, $maxLength = 100) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string ='';
		$length = mt_rand($minLength, $maxLength);
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters)-1)];
		}
		return $string;
	}

}
