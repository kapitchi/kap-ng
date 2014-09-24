<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace KapNg\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TemplateController extends AbstractActionController
{
    public function templateAction()
    {
        $template = $this->params()->fromRoute('template');
        $resolver = $this->getServiceLocator()->get('ViewResolver');
        if(!$resolver->resolve($template)) {
            return $this->notFoundAction();
        }
        
        $model = new ViewModel();
        $model->setTemplate('ng-template/' . $template);
        $model->setTerminal(true);//disable layout
        
        return $model;
    }
    
}
