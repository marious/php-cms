<?php
class Template
{
    protected $css = [
        'main.css',
        'slider-style.css'
    ];

    protected $js = [
        'jquery-1.11.2.min.js',
        'script.js'
    ];

    protected $template = [
        'header.php',
        'slider.php',
        'pageBody.php',
        'footer.php'
    ];

    public function __construct()
    {
        $this->appGuard();
        $output = '<!DOCTYPE html>' . PHP_EOL;
        $output .= '<html lang="en">';
        $output .= '<head>' . PHP_EOL;
        $output .= $this->setTitle('Bussiness Web Design');
        $output .= $this->setEncoding();
        $output .= $this->addMeta('keywords', 'business, web, design, corportate');
        $output .= $this->addMeta('description', 'This is business web site');
        $output .= $this->setBase();
        $output .= $this->setCss();
        $output .= $this->setJs();
        $output .= '</head>' . PHP_EOL . '<body>' . PHP_EOL;
        echo $output;
        $this->callTemplate();
    }

    protected function setCss()
    {
        $styles = [];
        foreach ($this->css as $css) {
            if (file_exists(CSS_PATH . $css)) {
                $styles[] = '<link rel="stylesheet" href="' . CSS_DIR . $css . '">';
            }
        }
        return "\t" . implode(PHP_EOL . "\t", $styles) . PHP_EOL;
    }

    protected  function setJs()
    {
        $scripts = [];
        foreach ($this->js as $js) {
            if (file_exists(JS_PATH . $js)) {
                $scripts[] = '<script src="' . JS_DIR . $js . '"></script>';
            }
        }
        return "\t" . implode(PHP_EOL . "\t", $scripts) . PHP_EOL;
    }

    protected function setTitle($title)
    {
        return "\t" . '<title>' . $title . '</title>' . PHP_EOL;
    }

    protected function setEncoding($encoding = 'utf8')
    {
        return "\t" . '<meta charset="' . $encoding . '">';
    }

    protected function addMeta($name, $content)
    {
        return "\t" . '<meta name="' . $name . '" content="' . $content . '">' . PHP_EOL;
    }

    protected function setBase()
    {
        return "\t" . '<base href="' . HOST_NAME . '">' . PHP_EOL;
    }

    protected function callTemplate()
    {
        foreach ($this->template as $template) {
            if (file_exists(WEB_TEMPLATE_PATH . $template)) {
                require_once WEB_TEMPLATE_PATH . $template;
            }
        }
    }

    public function getView()
    {
        return !empty(Path::get_path()['call_parts'][0]) ? Path::get_path()['call_parts'][0] : 'index';
    }

    public function renderView()
    {
       $view = $this->getView();
        if (file_exists(WEB_VIEWS_PATH . $view . '.view.php')) {
            require_once WEB_VIEWS_PATH . $view . '.view.php';
        } else {
            require_once WEB_VIEWS_PATH . '404.view.php';
        }
    }

    public static  function highlight($nav) {
        if ( !empty(Path::get_path()['call_parts'][0]) ) {
            if (Path::get_path()['call_parts'][0] == $nav) {
                return 'active';
            }
        } else {
            if ($nav == 'index') {
                return 'active';
            }
        }

    }

    private function appGuard()
    {
        $view = $this->getView();
        $pages = ['register', 'login', 'active'];
        if (User::isLoggedIn()) {
            if (in_array($view, $pages)) {
                header('Location: ' . HOST_NAME);
            }
        }
    }
}