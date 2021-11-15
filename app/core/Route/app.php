<?php 
namespace App\core\Route; 

/**
 * 
 * Step 1 : use App\Controllers\Controller;
 * Step 2 : (new Controller)
 * 
 */

 /**
  * Step 1 
  */
use App\Controllers\CategoryController;
use App\Controllers\ProductsController;
use App\Controllers\UserController;
use App\Controllers\SliderController;
use App\Controllers\HomeController;
use App\Controllers\DasController;
use App\Controllers\CommentController;
use App\Middleware\Role;

abstract class contruct{
    protected $url;
    protected $arr;
    public function __construct()
    {
        $this->url = $_GET['url'] ?? '/';

        /**
         * 
         * Step 2 
         * 
         */

        $this->arr = [
            (new HomeController),
            (new UserController),
            (new DasController),
            (new ProductsController),
            (new CategoryController),
            (new CommentController),
            (new SliderController)
        ];

    }
}