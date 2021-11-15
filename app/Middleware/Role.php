<?php 
namespace App\Middleware;

class Role {
    static function role(){ 
        if($_SESSION['user']['admin'] == 0) {
            return redirect('/');
        }
    }
}