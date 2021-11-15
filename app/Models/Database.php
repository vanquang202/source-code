<?php

namespace App\Models;  
use PDO; 
  

/** 
 * 
 * @getData 
 * 
 * @interface 
 * 
*/

interface getData{

    public function all();  

    public function find($id); 

    public function where($key, $value, $limit , $page , $order);

    public function whereAndWhere($array, $arraySupper);

    public function whereOne($key, $value); 

    public function searchEmail($email); 

}

interface request{ 

    public function create($arr);

    public function update($arr , $id);

    public function destroy($id);

    public function sql($sql);

    public function hasJoin($table, $value, $dk);

}

abstract class connect{

    protected $connect;  
 
    /** 
     * @__construct
     * @param
     * 
     */

    public function __construct()
    {

        try { 

            $this -> checkTable(); 
            $this->connect = new PDO('mysql:host=localhost;dbname=localname;charset=UTF8', 'root', '', [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

        } catch (\PDOException $e) { 

            echo $e;
            
        }

    } 

    /** 
     * @__destruct
     * @param
     * 
     */

    public function __destruct() {

        $this->connect = null; 

    }
    protected function checkTable(){

        if(!ctype_alnum($this->table)){ return false ; };

    }  
}
     
class Database 
    extends connect 
    implements getData , request 
    {
        
        /** 
         * 
         * @all 
         * 
         * @public 
         * 
        */

        public function all($limit = 0, $page = 0)
        {

            try { 

                if ($limit == 0 && $page == 0) {
                    $model = $this->connect->prepare("select * from " . $this->table . " order by id desc");
                } else {
                    $model = $this->connect->prepare("select * from " . $this->table . " order by id desc limit $page , $limit");
                }
                $model->execute();
                return $model->fetchAll();

            } catch (\PDOException $e) {

                echo $e;

            }

        }

        /** 
         * 
         * @find 
         * 
         * @public 
         * 
        */

        public function find($id)
        {

            try {

                //code...
                $model = $this->connect->prepare(" select * from " . $this->table . " where id = '$id'");
                $model->execute();
                return $model->fetch();

            } catch (\PDOException $e) {

                echo $e;

            }

        }
       
         /** 
         * 
         * @where 
         * 
         * @public 
         * 
        */
        public function where($key, $value, $limit = 0, $page = 0, $order = 'desc')
        {

            try {

                if ($limit == 0  &&  $page == 0) {
                    rtrim($value,"-");
                    trim($value,"-"); 
                    $model = $this->connect->prepare(" select * from " . $this->table . " where $key = '$value'" . " order by id desc");
                } else {
                    $model = $this->connect->prepare(" select * from " . $this->table . " where $key = '$value'" . "  limit $page , $limit   ");
                }
                $model->execute();
                return $model->fetchAll();

            } catch (\PDOException $e) {

                echo $e;

            }

        }

        /** 
         * 
         * @like 
         * 
         * @public 
         * 
        */
        
        public function like($key, $value,  $order = 'desc')
        {

            try { 

                if($value == false) {
                    $sql = "select * from " . $this->table . " where ";
                    $i = 0 ;
                    foreach($key as $vax =>  $vam) {
                        $i = $i +  1  ;
                        ($i == count($key)) ? $sql .= " $vax like '%$vam%' "  : ( $sql .= " $vax like '%$vam%' or " ); 
                    }    
                    $model = $this->connect->prepare($sql);
                }else{
                    $model = $this->connect->prepare(" select * from " . $this->table . " where $key like '%$value%'" . "  ");
                }
                $model->execute();
                return $model->fetchAll();

            } catch (\PDOException $e) {

                echo $e;

            }

        }

        /** 
         * 
         * @whereAndWhere 
         * 
         * @public 
         * 
        */

        public function whereAndWhere($array = 0, $arraySupper = 0)
            {

                $dk = '';
                if ($array != 0) {
                    // foreach ($array as $key => $value) {
                        //     $dk .= ' ' .  $key . '=' . $value . ' and';
                        // };
                    array_walk( $array, function ($val , $key) use (&$dk){
                        $dk .= ' ' . $key . '=' . $val . ' and' ; 
                    });
                }
                if ($arraySupper != 0) {
                    // foreach ($arraySupper as $key => $val) {
                        //     $dk .= ' ' . $key . ' ' . $val . ' ';
                        // };
                    array_walk( $arraySupper , function ($val , $key) use (&$dk) {
                        $dk .= ' ' . $key . ' ' . $val . ' ';
                    });
                }
                $dkN = rtrim($dk, "and");
                $model = $this->connect->prepare(" select * from " . $this->table . " where $dkN " . " order by id desc");
                $model->execute();

                return $model->fetchAll();

            }

        /** 
         * 
         * @whereOne 
         * 
         * @public 
         * 
        */

            public function whereOne($key, $value)
        {

            try {

                //code...
                $model = $this->connect->prepare(" select * from " . $this->table . " where $key = '$value'");
                $model->execute();
                return $model->fetch();

            } catch (\PDOException $e) {

                echo $e;

            }

        }

        /** 
         * 
         * @create 
         * 
         * @public 
         * 
        */

        public function create($arr)
        {

            $sql = " insert into " . $this->table;
            $keySql = " ( ";
            $valSql = " ( "; 
            array_walk($arr , function($val , $key) use (&$keySql , &$valSql){ 
                $keySql .= " $key ,";
                $valSql .= " '$val' ,";
            });
            $keySql = rtrim($keySql, ",");
            $valSql = rtrim($valSql, ",");
            $keySql .= " ) ";
            $valSql .= " ) ";
            $sql .= $keySql . " values " . $valSql;
            $model = $this->connect->prepare($sql);

            return $model->execute();

        }


        /** 
         * 
         * @update 
         * 
         * @public 
         * 
        */


        public function update($arr, $id)
        {

            $sql = "update " . $this->table . " set ";
            // foreach ($arr as $key => $val) {
                //     $sql .= " $key = '$val' ,";
                // }
            array_walk( $arr , function ($val , $key) use (&$sql){ 
                $sql .= " $key = '$val' ,";
            });

            $sql = rtrim($sql, ",");
            $sql .= " where id = " . $id;
            $model = $this->connect->prepare($sql);

            return $model->execute(); 

        }

        // ****************************************************************

        public function destroy($id)
        {

            $model = $this->connect->prepare(" delete from " . $this->table . " where id = '$id'");

            return $model->execute();

        }

        // ****************************************************************

        public function sql($sql)
        {

            $model = $this->connect->prepare($sql); 
            $model->execute();

            return $model->fetchAll();
        } 

        // ****************************************************************
        // Search

        public function searchEmail($email)
        {

            $model = $this->connect->prepare(" select * from " . $this->table . " where email = '$email' " . " order by id desc");
            $model->execute();

            return  $model->fetch();

        }

        // ****************************************************************
        //Has join

        public function hasJoin($table = [], $value = [], $dk = [])
        {

            $sql = " SELECT ";
            foreach ($value as $key => $val) {
                $sql .= $key . "." . $val . " ,";
            }
            $sql =  rtrim($sql, ",");
            $sql .= " from  ";
            $where = " on ";
            foreach ($table as $key => $value) { 
                if (end($table) === $value) {
                    $where .= "  $key.$value ";
                    $sql .= " $key ";
                } else {
                    $where .= "  $key.$value = ";
                    $sql .= " $key inner join ";
                }
            }
            foreach ($dk as $key => $value) {
                $where .= " where $key = $value ";
            }
            $sql = rtrim($sql, "NULL");
            $sql .= $where;
            // echo $sql;
            $model = $this -> connect->prepare($sql);
            $model -> execute(); 

            return  $model -> fetchAll() ;

            // $sql = "SELECT a.* , b.* FROM `products` AS a INNER JOIN `category` as b  ON a.category_id = b.id WHERE a.category_id = 3";
        
        }
    }
