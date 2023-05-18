<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../api/config.php');
//$_POST = json_decode(file_get_contents('php://input'), true);



if (
    $_SERVER["REQUEST_METHOD"] == "GET"
) {
    $sql = "SELECT * FROM Students ";
    $stmt = $db->prepare($sql);
    if ($stmt->execute()) {
        $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "asdfas";
        echo json_encode($response);
    }
    return;
}


function insertStudentDB($email,$aisId,$name,$surname){

    require('../api/config.php');

    try{
        $sql = "INSERT INTO Students (email, aisId, name, surname) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$email, $aisId, $name, $surname])) {
            return "ok";
        }        

    }catch(PDOException $e){
        echo $e->getMessage();
        return "NotOk";
    }

    

}

?>