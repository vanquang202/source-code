<?php 
namespace App\Services;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Products;
use App\Models\Slider;
use App\Models\User; 

class Services { 
      static function all($table ) {
        return $table->all(); 
     }
     static function create($tabel , $value = []) {
        return $tabel->create($value);
     }
     static function update($tabel , $value = [] , $id) {
        return $tabel->update($value, $id);
     } 
     static function destroy($tabel , $id) {
        return $tabel->destroy($id);
     } 
}