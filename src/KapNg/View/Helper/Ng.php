<?php

namespace KapNg\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;

class Ng extends AbstractHelper implements FactoryInterface
{
    protected $apps = [];
    protected $constants = [];

    /**
     * @TODO
     * Factory for itself
     * @param ServiceLocatorInterface $serviceLocator
     * @return \self
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $helper = new self;
        return $helper;
    }
    
    public function __invoke($target = null, $modules = null)
    {
        if($target !== null) {
            return $this->bootstrap($target, $modules);
        }
        
        return $this;
    }
    
    public function __toString()
    {
        return $this->render();
    }

    public function bootstrap($target, $modules)
    {
        $this->apps[$target] = (array)$modules;
    }
    
    public function constant($key, $value = null)
    {
        if(is_array($key)) {
            foreach($key as $cKey => $value) {
                $this->constant($cKey, $value);
            }
            return;
        }
        
        $this->constants[$key] = $value;
    }

    public function render()
    {
        return $this->getView()->partial(
            'kap-ng/loader',
            array(
                'apps' => $this->apps,
                'constants' => $this->constants
            )
        );
    }

    
}
