<?php

namespace App\core;

use App\core\Route\contruct ;  
require_once('../app/core/Route/app.php');  

class Route extends contruct
{ 
   
    /**
     * @param string $url 
     * @param callable|string  $methods 
     */
    static function get($url, $methods)
    {
        $_this = new static;

        ($url == '/') ?
        $urls = ['/','/'] :
        $urls = explode('/', $url);
    
        if ($_this->url == reset($urls)) { 

            if ( gettype( $methods ) == 'object' ) {
                $methods();
                die;
            }
 
            $class = null;
            $list = explode( "@" ,   $methods );

            foreach ($_this->arr as $val) {

                $asd = explode( '\\' , get_class($val) ) ;
                if (reset($list) == end($asd)) { 
                    $class = $val;
                }

            } 

            $mf = get_class_methods($class);

            foreach ($mf as $vax) {

                ($vax == end($list)) ?
                    ((end($list) == $vax) ?
                        ($class::$vax(((count($urls) == 2 && end($urls) !== '/') ?
                            $_GET[end($urls)] : null)) ? '' :  '')
                        : '') : '';

            }

            return $_this;
            
        }
    }  
}
