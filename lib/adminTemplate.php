<?php

class adminTemplate extends Template
{
    protected $css = [
        'main.css',
        'admin.css'
    ];

    protected $js = [
        'jquery-1.11.2.min.js',
        'admin.js'
    ];

    protected $template = [
        'header.php',
        'pageBody.php',
        'footer.php'
    ];

    public function __construct()
    {
        $output = '<!DOCTYPE html>' . PHP_EOL;
        $output .= '<html lang="en">';
        $output .= '<head>' . PHP_EOL;
        $output .= $this->setTitle('Admin Cpanel');
        $output .= $this->setEncoding();
        $output .= $this->setBase();
        $output .= $this->setCss();
        $output .= $this->setJs();
        $output .= '</head>' . PHP_EOL . '<body>' . PHP_EOL;
        echo $output;
        $this->callTemplate();
    }

    protected function callTemplate()
    {
        foreach ($this->template as $template) {
            if (file_exists(ADMIN_TEMPLATE_PATH . $template)) {
                require_once ADMIN_TEMPLATE_PATH . $template;
            }
        }
    }

    public function renderView()
    {
       if ( User::isLoggedIn() && User::theUser()->isAdmin() ) {
           $view = $this->getView();
           if (file_exists(ADMIN_VIEWS_PATH . $view . '.view.php')) {
               require_once ADMIN_VIEWS_PATH . $view . '.view.php';
           } else {
               require_once ADMIN_VIEWS_PATH . '404.view.php';
           }
       } else {
           require_once ADMIN_VIEWS_PATH . 'restricted.view.php';
       }
    }
}