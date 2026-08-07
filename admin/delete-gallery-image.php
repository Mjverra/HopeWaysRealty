<?php

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../includes/db_connect.php";
require_once "../includes/cloudinary.php";
if (!isset($_GET['id']) || !isset($_GET['property'])) {

    die("Invalid request.");

}

$imageId = (int) $_GET['id'];
$propertyId = (int) $_GET['property'];