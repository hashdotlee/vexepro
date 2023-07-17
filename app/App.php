<?php
class App {
    private string $__controller_name = 'Home';
    private string $__action = 'index';
    private array $__params;
    function __construct() {
        $this->handleUrl();
    }

    function getUrl() {
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else $url = '/';

        return $url;
    }

    public function handleUrl() : void {
        $url = $this->getUrl();
        $urlArr = array_filter(explode('/', $url));
        $urlArr = array_values($urlArr);
        $controller = null;

        // Controller process
        if (!empty($urlArr[0])) {
            $this->__controller_name = ucfirst($urlArr[0]);
        }

        // Load controller class
        if (file_exists('app/controllers/'.($this->__controller_name).'.php')) {
            require_once 'controllers/'.($this->__controller_name).'.php';
            if (class_exists($this->__controller_name)) {
                $controller = new $this->__controller_name();
                unset($urlArr[0]);
            }
        } else {
            $this->loadError();
        }

        // Action process
        if (!empty($urlArr[1])) {
            $this->__action = $urlArr[1];
            unset($urlArr[1]);
        }
        $this->__params = array_values($urlArr);

        if (method_exists($controller, $this->__action)) {
            // Filter processing
            global $filters;
            $filterName = $this->matchFilter($filters, $this->__controller_name, $this->__action);

            require_once 'filters/'.$filterName.'.php';
            $filter = new $filterName($controller, $this->__action, $this->__params);
            $filter->run($url);
        } else {
            $this->loadError();
        }
    }

    public function loadError($name='404') : void {
        require_once 'errors/'.$name.'.php';
    }

    private function matchFilter(array $filters, string $controller, string $action) : string {
        foreach ($filters as $filter=>$urls) {
            foreach ($urls as $url) {
                $elems = explode('/', $url);
                if ($elems[0] == '*' || $elems[0] == lcfirst($controller)) {
                    if ($elems[1] == '*' || $elems[1] == $action) {
                        return $filter;
                    }
                }

            }
        }
        return 'DefaultFilter';
    }
}