<?php

namespace KapNg\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;

class NgTemplate extends AbstractRightsterHelper
{
    protected $rendered = array();

    public function render($id)
    {
        if ($this->isRendered($id)) {
            return;
        }

        $this->rendered[] = $id;

        $content = @file_get_contents('public/template/' . $id . '.html');
        if($content === false) {
            throw new InvalidArgumentException("Ng-template '$id' doesn't exist in template folder");
        }

        return <<<HTML
    <script type="text/ng-template" id="template/{$id}.html">{$content}</script>
HTML;

    }

    public function isRendered($id)
    {
        return in_array($id, $this->rendered);
    }
    
    public function __toString()
    {
        return $this->render();
    }

    public function __invoke($id = null)
    {
        if ($id !== null) {
            return $this->render($id);
        }

        return $this;
    }
}
