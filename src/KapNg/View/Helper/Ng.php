<?php

namespace KapNg\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;

class Ng extends AbstractHelper implements FactoryInterface
{
    protected $apps = [];
    protected $constants = [];
    protected $rootScope = [];
    protected $templates = [];
    protected $loaderTemplate = 'kap-ng/loader';
    protected $lastTarget = 'document';//TODO should this be default?
    
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
        if(empty($modules)) {
            $modules = $target;
            
            if(empty($this->lastTarget)) {
                //TODO proper exception
                throw new \Exception("Last target unknown");
            }
            
            $target = $this->lastTarget;
        }
        
        if(!isset($this->apps[$target])) {
            $this->apps[$target] = [];
        }
        
        $this->apps[$target] = array_merge($this->apps[$target], (array)$modules);
        
        $this->lastTarget = $target;
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
    
    public function scopeVar($key, $value = null)
    {
        if(is_array($key)) {
            foreach($key as $cKey => $value) {
                $this->scopeVar($cKey, $value);
            }
            return;
        }

        $this->rootScope[$key] = $value;
    }
    
    public function template($id)
    {
        
    }
    

    public function render()
    {
        return $this->getView()->partial(
            $this->loaderTemplate,
            array(
                'apps' => $this->apps,
                'constants' => $this->constants,
                'rootScope' => $this->rootScope,
            )
        );
    }

    
}
