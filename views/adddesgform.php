<?php
require_once "../models/departments.php";
require_once "../models/designations.php";
require_once "../config/dbconfig.php";
$desgAdded = false;
$duplicate = false;
$error = false;
$deptModel = new DeptModel($conn);
$departments = $deptModel->findAll();

if (isset($_POST['submitDesg'])) {
    if(
        !isset($_POST['Name'])
    ) {
        exit("invalid input");
    }
    $desgModel = new DesgModel($conn);
    $result = $desgModel->insert($_POST);
    if($result == 'success'){
        $desgAdded = true;
    } 
    elseif($result == 'duplicate') {
        $duplicate = true;
    }
    else {
        $error = true;
    }
}
?>
<h2 class="ps-2">Add Desgination</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-12 col-md-6 align-self-center">
    <?php if($desgAdded): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            Designation added succesfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($duplicate): ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            Designation not added, duplicate entry!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($error): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            Designation cannot be added due to some error/invalid entry!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        <form class="border rounded p-2 border-light" method="POST">
            <div class="mb-3">
                <label for="dept-select" class="col-form-label">Select Department</label>
                <select name="DepartmentId" id="dept-select" class="select2 form-control" data-allow-clear="true">
                <?php foreach($departments as $department): ?>
                    <option value="<?= $department['Id'] ?>"><?= $department['Name'] ?></option>
                <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="desg-input" class="col-form-label">Create Designation</label>
                <input name="Name" class="form-control" type="text" placeholder="Enter name here" id="desg-input" />
            </div>
            <div class="d-flex flex-row-reverse">
                <button type="submit" name="submitDesg" value="submit" class="btn rounded-pill me-2 btn-primary">Submit</button>
            </div>

        </form>
    </div>
</div>