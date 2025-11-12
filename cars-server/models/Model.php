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
    
    // $data = ['name'=>'merc', 'color'=>'blue','year'=>'2025']
    public static function create(mysqli $connection,array $data)
    {
        if (empty($data) || !is_array($data)) {
            throw new InvalidArgumentException('Data must be a non-empty array.');
        }

        $cols = array_keys($data);//("name", "color", "year")
        $placeholder = implode(',', array_fill(0,count($cols), '?'));//"?,?,?" 
        $values = array_values($data); //("merc", "blue", "2025")
        $types = '';

    
        foreach ($values as $v) {
            if (is_int($v)) {
                $types .= 'i';
            } elseif (is_float($v)) {
                $types .= 'd';
            } elseif (is_null($v)) {
                // no dedicated NULL type; bind as 's' with null value is OK
                $types .= 's';
            } else {
                $types .= 's';
            }
        }

        $sql = "INSERT INTO " . static::$table .
        "(" . implode(',', $cols) . ") VALUES ($placeholder)";// (name = merced , color = blue , year = 2025)
        $query = $connection->prepare($sql);
        $query->bind_param($types, ...$values);
        $query->execute();
       
        return $query->insert_id;
         
 
    }
     

}



?>
