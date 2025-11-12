<?php
include("../models/Car.php");
include("../connection/connection.php");
include("../services/ResponseService.php");

function getCarByID(){
    global $connection;

    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }else{
        echo ResponseService::response(500, "ID is missing");
        return;
    }

    $car = Car::find($connection, $id);
    echo ResponseService::response(200, $car->toArray());
    return;
}
function getCars(){
    global $connection;
    $all_data = [];
    
    $rows = Car::findAll($connection);
   
    if(empty($rows)){
        echo ResponseService::response(500,"Row is empty");
    }
    foreach($rows as $car){
        $all_data[] = $car->toArray();
    }
    echo ResponseService::response(200, $all_data);
    return;
}
//getCarById();
//getCars();

function insertCar(string $name, string $color, string $year){
    global $connection;

        if ($name === '' || $color === '' || $year === '') {
        echo ResponseService::response(400, "Missing fields");
        return;
    }

    $data =['name' => $name, 'color' => $color, 'year' => $year];

    $insert = Car::create($connection,$data);
    try{
        if($insert){
            echo ResponseService::response(200,"Data is inserted succ");
        }
    }catch(error){
        echo ResponseService::response(500," insert failed");
    }   
    
}
//insertCar('sherokee','black','2019');

function updateCar(string $name, string $color, string $year){  
    global $connection;

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    $data = [];

    if($name !== ''){
        $data['name'] = $name;
    }
    if($color !== ''){
        $data['color'] = $color;
    }
    if($year !== ''){
        $data['year'] = $year;
    }
  var_dump($data);
    if(empty($data)){
        echo ResponseService::response(400, "No fields to update");
        return;
    }
    try{
        $result = Car::update($connection, $id, $data);
    }catch(error){
        echo ResponsiveService::response(500,"Update failed");
    }
}
updateCar("nabiha", "red", "2018");

function deleteCar(){
    global $connection;

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    Car::delete($connection, $id);
    echo ResponseService::response(200,"row is Deleted");
}
//deleteCar();
//ToDO: 
//transform getCarByID to getCars()
//if the id is set? then we retrieve the specific car 
// if no ID, then we retrieve all the cars


?>