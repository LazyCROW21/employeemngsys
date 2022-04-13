<?php
require_once "../models/users.php";
require_once "../models/clients.php";
require_once "../models/projects.php";
require_once "../config/dbconfig.php";
$userModel = new UserModel($conn);
$clientModel = new ClientModel($conn);
$users = $userModel->findAllActive();
$clients = $clientModel->findAllActive();

$projectAdded = false;
$duplicate = false;
$error = false;
$projectModel = new ProjectModel($conn);

if (isset($_POST['submitProject'])) {
    if(
        !isset($_POST['Title']) || !isset($_POST['Description']) ||
        !isset($_POST['LeadId']) || !isset($_POST['StartedAt'])
    ) {
        exit("invalid input");
    }
    $_POST['Completed'] = 0;
    $_POST['Dropped'] = 0;
    $_POST['CreatedBy'] = $_SESSION['UserId'];
    $result = $projectModel->insert($_POST);
    if($result == 'success'){
        $projectAdded = true;
    } 
    elseif($result == 'duplicate') {
        $duplicate = true;
    }
    else {
        $error = true;
    }
}
?>
<h2 class="ps-2">Add Project</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-12 col-md-6 align-self-center">
        <?php if($projectAdded): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            Project added succesfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($duplicate): ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            Project not added, duplicate entry!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($error): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            Project cannot be added due to some error/invalid entry!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        <form class="border rounded p-2 border-light" method="POST">
            <div class="mb-3">
                <label for="proj-input" class="col-form-label">Project title</label>
                <input name="Title" class="form-control" type="text" placeholder="Enter title here" id="proj-input" required/>
            </div>
            <div class="mb-3">
                <label for="desc-input" class="col-form-label">Project description</label>
                <textarea name="Description" class="form-control" type="text" placeholder="Enter name here" id="desc-input" required></textarea>
            </div>
            <div class="mb-3">
                <label for="client-input" class="col-form-label">Client <span class="text-muted">(Optional)</span></label>
                <select name="ClientId" class="select2 form-control" multiple="multiple" id="client-input">
                <?php foreach($clients as $client): ?>
                    <option value="<?= $client['Id'] ?>"><?= $client['Name'] ?></option>
                <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3 row">
                <div class="col-12 col-md-6">
                    <label for="sdate-input" class="col-form-label">Starting date</label>
                    <input name="StartedAt" class="form-control" type="date" value="" id="sdate-input" required />
                </div>
                <div class="col-12 col-md-6">
                    <label for="dline-input" class="col-form-label">Deadline <span class="text-muted">(Optional)</span></label>
                    <input name="Deadline" class="form-control" type="date" value="" id="dline-input"/>
                </div>
            </div>
            <div class="mb-3">
                <label for="earn-input" class="col-form-label">Earning (in Rs.) <span class="text-muted">(Optional)</span></label>
                <input name="Earning" class="form-control" type="number" min="0" step="0.01" placeholder="150000" id="earn-input"/>
            </div>
            <div class="mb-3">
                <label for="name-input" class="col-form-label">Select Lead</label>
                <select name="LeadId" class="select2 form-control" required>
                <?php foreach($users as $user): ?>
                    <option value="<?= $user['Id'] ?>"><?= $user['Name'] ?> (<?= $user['DesignationName'] ?>,<?= $user['DepartmentName'] ?>)</option>
                <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="name-input" class="col-form-label">Select Team <span class="text-muted">(Optional)</span></label>
                <select name="Team[]" class="select2 form-control" multiple="multiple">
                <?php foreach($users as $user): ?>
                    <option value="<?= $user['Id'] ?>"><?= $user['Name'] ?> (<?= $user['DesignationName'] ?>,<?= $user['DepartmentName'] ?>)</option>
                <?php endforeach; ?>
                </select>
            </div>
            <div class="d-flex flex-row-reverse">
                <button type="submit" name="submitProject" value="submit" class="btn rounded-pill me-2 btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>