<?php

namespace Core;

use Exception;

class View
{
    private $_siteTitle = '', $_content = [], $_currentContent, $_buffer, $_layout;
    private $_defaultViewPath;

    public function __construct(string $path = '')
    {
        $this->_defaultViewPath = $path;
        $this->_siteTitle = Config::get('default_site_title');
    }

    public function setLayout(mixed $layout): void
    {
        $this->_layout = $layout;
    }

    /**
     * @throws Exception
     */
    public function render(string $path = ''): void
    {
        if(empty($path)) {
            $path = $this->_defaultViewPath;
        }
        $layoutPath = PROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . $this->_layout . '.php';
        $fullPath = PROOT . DS . 'app' . DS . 'views' . DS . $path . '.php';
        if (!file_exists($fullPath)) {
            throw new Exception(Errors::get('5001'), 5001);
//            throw new Exception("The view \"{$path}\" does not exist.");
        }
        if (!file_exists($layoutPath)) {
            throw new Exception(Errors::get('5002'), 5002);
//            throw new Exception("The layout \"{$this->_layout}\" does not exist.");
        }
        include($fullPath);
        include($layoutPath);
    }

    /**
     * @throws Exception
     */
    public function start($key)
    {
        if (empty($key)) {
            throw new \Exception("Your start method requires a valid key.");
        }
        $this->_buffer = $key;
        ob_start();
    }

    /**
     * @throws Exception
     */
    public function end()
    {
        if (empty($this->_buffer)) {
            throw new \Exception("You must first run the start method.");
        }
        $this->_content[$this->_buffer] = ob_get_clean();
        $this->_buffer = null;
    }

    public function content($key)
    {
        if (array_key_exists($key, $this->_content)) {
            echo $this->_content[$key];
        } else {
            echo '';
        }
    }

    public function partial($path)
    {
        $fullPath = PROOT . DS . 'app' . DS . 'views' . DS . $path . '.php';
        if (file_exists($fullPath)) {
            include($fullPath);
        }
    }
}