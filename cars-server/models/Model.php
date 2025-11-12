<?php

abstract class Model{
    
    protected static string $table;
    protected static string $primary_key = "id";

    public static function find(mysqli $connection, int $id){
        $sql = sprintf("SELECT * from %s WHERE %s = ?",
                       static::$table,
                       static::$primary_key);

        $query = $connection->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();               

        $data = $query->get_result()->fetch_assoc();

        return $data ? new static($data) : null;
    }


    public static function findAll(mysqli $connection){

        $sql = sprintf("SELECT * from %s",
                        static::$table);
        $query = $connection->prepare($sql);
    
        $query->execute();

        $data = $query->get_result();
        $rows = [];
        while($row = $data->fetch_assoc()){
            $rows[] = new static($row);
        }
       // var_dump($rows);

        return $rows;
        
    }

    public static function create(mysqli $connection, array $data[]){
        $sql = sprintf("INSERT INTO %s (name,color,year) VALUES (?,?,?)", 
                        static::$table);
        $query = $connection->prepare($sql);
        $query->bind_param("sss",$name,$color,$year);
        $query->execute();
        if(!$query){
            return "fail to create";
        }
    }

    public static function update(mysqli $connection, int $id,string $name, string $color , string $year){
        $sql = sprintf("UPDATE %s SET  name = ?, color = ?, year = ?   WHERE %s = ?",
                        static::$table,
                        static::$primary_key);
        $query = $connection->prepare($sql);
        $query->bind_param("sssi",$name,$color,$year, $id);
        $query->execute();
        
        if(!$query){
            return "fail to update";
        }
    }

    public static function delete(mysqli $connection, int $id){
        $sql = sprintf("DELETE FROM %s WHERE %s = ?",
                static::$table,
                static::$primary_key);
        $query = $connection->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        if(!$query){return "fail to delete";
        }
    }

}



?>
