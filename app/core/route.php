<?php

namespace App\Core ;
    session_start();
    
    require_once "../app/core/core.php";    
    require_once "../app/core/config.php";    
    require '../vendor/autoload.php';

    $url = $_GET['url'] ?? '/';   
    
    function check($arr = []) {
        return in_array( $GLOBALS['url'] , $arr)
        ? '' :  ((!isset($_SESSION['user']) 
        && empty($_SESSION['user'])) 
        ?  redirect('/login') : '');  
}  

/* 
*
* NOTE CHECK LOAD LOGIN  
*
*/

check(
    [
    'login' , 'logup' ,'checkLogin','logup-user'
    ]
);      

/**
 * 
 * NOTE SET URL BACK
 * 
 */ 

set_url_back_time($url);

/**
 * 
 * NOTE WEITCH URL
 * 
 */ 

Route::get('/' , 'Controller@index' );
 