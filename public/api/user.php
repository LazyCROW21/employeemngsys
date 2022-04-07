<?php
require_once '../../config/checksession.php';
require_once "../../models/users.php";
require_once "../../config/dbconfig.php";
$userAdded = false;
$duplicate = false;
$error = false;

if (isset($_GET['Id'])) {
    $userModel = new UserModel($conn);
    $result = $userModel->findById($_GET['Id']);
    echo json_encode($result);
} else {
    exit("invalid input");
}
?>