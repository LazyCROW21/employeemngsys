<?php
require_once "../models/departments.php";
require_once "../config/dbconfig.php";
$deptAdded = false;
$duplicate = false;
$error = false;
if (isset($_POST['submitDept'])) {
    if(
        !isset($_POST['Name'])
    ) {
        exit("invalid input");
    }
    $deptModel = new DeptModel($conn);
    $result = $deptModel->insert($_POST);
    if($result == 'success'){
        $deptAdded = true;
    } 
    elseif($result == 'duplicate') {
        $duplicate = true;
    }
    else {
        $error = true;
    }
}
?>
<h2 class="ps-2">Add Department</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-12 col-md-6 align-self-center">
        <?php if($deptAdded): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            Department added succesfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($duplicate): ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            Department not added, duplicate entry!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($error): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            Department cannot be added due to some error/invalid entry!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        <form class="border rounded p-2 border-light" method="POST">
            <div class="mb-3">
                <label for="name-input" class="col-form-label">Department Name</label>
                <input name="Name" class="form-control" type="text" placeholder="Enter name here" id="name-input" />
            </div>
            <div class="d-flex flex-row-reverse">
                <button type="submit" name="submitDept" value="submit" class="btn rounded-pill me-2 btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>