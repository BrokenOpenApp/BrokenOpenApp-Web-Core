<?php
 
namespace JMBTechnology\BrokenOpenAppCoreBundle\EventListener;
 
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;

use JMBTechnology\BrokenOpenAppCoreBundle\Controller\IAcraServerController;
 
/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 * @author Vincent Prat @ MarvinLabs
 */
class BeforeControllerListener
{
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
 
        if (!is_array($controller)) {
            // not a object but a different kind of callable. Do nothing
            return;
        }
 
        $controllerObject = $controller[0];
 
        // skip initializing for exceptions
        if ($controllerObject instanceof ExceptionController) {
            return;
        }
 
        if ($controllerObject instanceof IAcraServerController) {

        }
    }
}