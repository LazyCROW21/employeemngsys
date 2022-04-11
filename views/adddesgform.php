<?php
require_once "../models/departments.php";
require_once "../models/designations.php";
require_once "../config/dbconfig.php";
$desgAdded = false;
$duplicate = false;
$desgUpdate = false;
$error = false;
$deptModel = new DeptModel($conn);
$departments = $deptModel->findAllActive();

$editDept = "";
$editDesignation = "";
$editPk = "";

$editFlag = false;



if (isset($_POST['submitDesg'])) {
    if(
        !isset($_POST['Name'])
    ) {
        exit("invalid input");
    }

    if (!isset($_POST['type'])) {
        exit("Invalid input!");
    }
    
    $desgModel = new DesgModel($conn);

    if (trim($_POST['type']) == "create") {
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
        // echo "create req received!";

    }
    else if (trim($_POST['type']) == "edit") {
        // echo "Edit req received!<br>";
        // echo $_POST['Id'];

        $result = $desgModel->update($_POST);
        if($result == 'success'){
            $desgUpdate = true;
        } 
        else {
            $error = true;
        }
    }
    else {
        // echo "no req received!";

    }

}


if (isset($_GET['edit'])) {
    $editFlag = true;
    // echo $_GET['edit'];
    $id = $_GET['edit'];

    $designationModel = new DesgModel($conn);
    $editData = $designationModel->getDesignationById($id);

    if ($editData != NULL) {

        $editDept =  $editData['Department'];
        $editDesignation =  $editData['Designation'];
        $editPk = $editData['Id'];
    }

    // echo $editData['Department']."<br>";
        // echo  $editData['Designation'];

}
?>
<h2 class="ps-2">
    <?php if (isset($_GET['edit'])): ?>
        Edit
    <?php else: ?>
    Add
    <?php endif; ?>
     Designation
</h2>
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
            Some error in processing the request! Try again later.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($desgUpdate): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            Designation updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        <form class="border rounded p-2 border-light" method="POST">
            <input type="hidden" name="type" value="
                <?php if(isset($_GET['edit'])): ?>edit
                <?php else: ?>create<?php endif; ?>
            ">

            <input type="hidden" name="Id" value="
                <?php if(isset($_GET['edit'])): ?><?= $editPk ?>
                <?php else: ?> <?php endif; ?>
            ">

            <div class="mb-3">
                <label for="dept-select" class="col-form-label">Select Department</label>
                <select name="DepartmentId" id="dept-select" class="select2 form-control" data-allow-clear="true" <?php if ($editFlag): ?> disabled <?php endif; ?> >
                <?php foreach($departments as $department): ?>
                    <option
                        <?php if ($editFlag && $department['Name'] == $editDept): ?>
                            selected
                        <?php endif; ?>
                     value="<?= $department['Id'] ?>"><?= $department['Name'] ?></option>
                <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="desg-input" class="col-form-label">Create Designation</label>
                <input name="Name" class="form-control" type="text" placeholder="Enter name here"
                    <?php if ($editFlag): ?>
                        value = "<?= $editDesignation ?>"
                    <?php endif; ?>
                    id="desg-input" />
            </div>
            <div class="d-flex flex-row-reverse">
                <button type="submit" name="submitDesg" value="submit" class="btn rounded-pill me-2 btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>