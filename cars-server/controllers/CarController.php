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
    $insert = Car::create($connection,$name, $color, $year);
    echo ResponseService::response(200,"Data is inserted succ");
}
//insertCar('bmw','white','2025');

function updateCar(string $name, string $color, string $year){
    global $connection;

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    // $car_info = [];
    // $car_info[] = $id;
    // $car_info[] = $name;
    // $car_info[] = $color;
    // $car_info[] = $year;
    // var_dump($car_info);

    Car::update($connection,$id,$name,$color,$year);

    echo ResponseService::response(200,"row is Updated");
}
//updateCar("hawawee", "blue", "2018");

function deleteCar(){
    global $connection;

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    Car::delete($connection, $id);
    echo ResponseService::response(200,"row is Deleted");
}
deleteCar();
//ToDO: 
//transform getCarByID to getCars()
//if the id is set? then we retrieve the specific car 
// if no ID, then we retrieve all the cars


?>