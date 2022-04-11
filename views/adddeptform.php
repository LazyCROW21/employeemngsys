<?php
require_once "../models/departments.php";
require_once "../config/dbconfig.php";

$deptAdded = false;
$duplicate = false;
$error = false;
$editFlag = false;
$deptUpdate = false;

$editDept = "";
$editPk = "";

if (isset($_POST['submitDept'])) {
    if(
        !isset($_POST['Name'])
    ) {
        exit("invalid input");
    }

    if (!isset($_POST['type'])) {
        exit("Invalid form");
    }

    $deptModel = new DeptModel($conn);
    
    if (trim($_POST['type']) == "create") {

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
    else if (trim($_POST['type']) == "edit") {
        $result = $deptModel->update($_POST);
        if ($result == "success") {
            $deptUpdate = true;
        }
        else {
            echo "alert('Error while updating department')";
            $error = true;
        }
    }
}


if (isset($_GET['edit'])) {
    $editFlag = true;
    $id = $_GET['edit'];

    $departmentModel = new DeptModel($conn);
    $editData = $departmentModel->getDepartmentById($id);

    if ($editData != NULL) {

        $editDept =  $editData['Name'];
        $editPk = $editData['Id'];
    }
}

?>
<h2 class="ps-2">
    <?php if ($editFlag): ?>
        Edit 
    <?php else: ?>
        Add 
    <?php endif; ?>
    Department</h2>
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
            Error while processing the request!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($deptUpdate): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            Department update successful!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        <form class="border rounded p-2 border-light" method="POST">
            <input type="hidden" name="type" value="
                <?php if($editFlag): ?>
                    edit
                <?php else: ?>
                    create
                <?php endif; ?>
            ">

            <input type="hidden" name="Id" value="
                <?php if ($editFlag): ?> <?= $editPk ?>
                <?php else: ?> ' ' <?php endif; ?>
            ">
            <div class="mb-3">
                <label for="name-input" class="col-form-label">Department Name</label>
                <input name="Name" class="form-control" type="text" placeholder="Enter name here" id="name-input" 
                    <?php if ($editFlag): ?> value="<?= $editDept ?>" <?php endif; ?>
                />
            </div>
            <div class="d-flex flex-row-reverse">
                <button type="submit" name="submitDept" value="submit" class="btn rounded-pill me-2 btn-primary">
                    <?php if ($editFlag): ?>
                        Update Department
                    <?php else: ?>
                        Submit
                    <?php endif; ?>
                </button>
            </div>
        </form>
    </div>
</div>