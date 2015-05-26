<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;

use Doctrine\ORM\Mapping\Entity;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class DefaultViewController extends Controller
{

    /**
     * Get the common paramaters to pass to the views
     */
    public function getViewParameters($additionalParameters=array()) {
    	return array_merge( array(

    		), $additionalParameters);
    }
    

}
