<?php

function createConObject(){
    return new mysqli("localhost", "root", "", "Event_Management");
}


function insertData($conn, $firstname, $surname, $phone, $dob, $address, $email,$password, $event, $myfile) {
    $sql = "INSERT INTO Users (firstname, surname, phone, dob, address, email,password, event, myfile )
            VALUES ( '$firstname', '$surname', '$phone', '$dob', '$address', '$email','$password', '$event', '$myfile')";
    if(mysqli_query($conn, $sql)){
        return true;
    } else {
        return false;
    }
}
function checkLogin($conn, $email, $password) {
    $sql = "SELECT * FROM Users WHERE email='$email' AND password='$password'";
    return  mysqli_query($conn, $sql);
}   


function getAllUsers($conn) {
    $query = "SELECT * FROM users";
    return mysqli_query($conn, $query);
}

function searchUsersByName($conn, $name) {
    $name = mysqli_real_escape_string($conn, $name);
    $query = "SELECT * FROM users WHERE firstname LIKE '%$name%' OR surname LIKE '%$name%'";
    return mysqli_query($conn, $query);
}



function getUserById($conn, $id) {
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT * FROM Users WHERE id = '$id'";
    return mysqli_query($conn, $sql);
}

function updateUser($conn, $id, $firstname, $surname, $phone, $dob, $address, $email, $event) {
    $id = mysqli_real_escape_string($conn, $id);
    $firstname = mysqli_real_escape_string($conn, $firstname);
    $surname = mysqli_real_escape_string($conn, $surname);
    $phone = mysqli_real_escape_string($conn, $phone);
    $dob = mysqli_real_escape_string($conn, $dob);
    $address = mysqli_real_escape_string($conn, $address);
    $email = mysqli_real_escape_string($conn, $email);
    $event = mysqli_real_escape_string($conn, $event);

    $sql = "UPDATE Users SET 
            firstname='$firstname', 
            surname='$surname', 
            phone='$phone', 
            dob='$dob', 
            address='$address', 
            email='$email', 
            event='$event' 
            WHERE id='$id'";
    
    return mysqli_query($conn, $sql);
}

function deleteUser($conn, $id) {
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "DELETE FROM Users WHERE id='$id'";
    return mysqli_query($conn, $sql);
}




function closeCon($conn) {
    $conn->close();
}

?>