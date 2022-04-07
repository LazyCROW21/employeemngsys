<?php
require_once "../models/users.php";
require_once "../models/permissions.php";
require_once "../config/dbconfig.php";
$updateSuccess = false;
$error = false;
$userModel = new UserModel($conn);
$users = $userModel->findAll();

$prModel = new PermissionModel($conn);
$editFlag = false;

$pDepartment = 'XXXX';
$pDesignation = 'XXXX';
$pUser = 'XXXX';
$pPayroll = 'XXXX';
$pProject = 'XXXX';
$pLeaves = 'XXXX';
$pClient = 'XXXX';
$pAdmin = 'XXXX';

if (isset($_GET['UserId'])) {
    $editFlag = true;

    $editData = $prModel->findById($_GET['UserId']);

    if ($editData != NULL) {
        $pDepartment =  $editData['Department'];
        $pDesignation =  $editData['Designation'];
        $pUser =  $editData['User'];
        $pPayroll =  $editData['Payroll'];
        $pProject =  $editData['Project'];
        $pLeaves =  $editData['Leaves'];
        $pClient =  $editData['Client'];
        $pAdmin =  $editData['Admin'];
    }

}

if (isset($_POST['submitP'])) {
    // if(
    //     !isset($_POST['Name'])
    // ) {
    //     exit("invalid input");
    // }
    // $desgModel = new DesgModel($conn);
    // $result = $desgModel->insert($_POST);
    // if($result == 'success'){
    //     $desgAdded = true;
    // } 
    // elseif($result == 'duplicate') {
    //     $duplicate = true;
    // }
    // else {
    //     $error = true;
    // }
}

$moduleData = [
    'Department' => $pDepartment,
    'Designation' => $pDesignation,
    'User' => $pUser,
    'Payroll' => $pPayroll,
    'Project' => $pProject,
    'Leaves' => $pLeaves,
    'Client' => $pClient,
    'Admin' => $pAdmin,
];

var_dump($moduleData);

?>
<h2 class="ps-2">Give Permission</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-12 col-md-8 align-self-center">
        <form id="select-emp" class="border rounded p-2 border-light mb-3" method="GET">
            <div class="mb-3">
                <label for="name-input" class="col-form-label">Select Employee</label>
                <select class="select2 form-control" data-allow-clear="true" onchange="submitEmp(this.value)">
                    <option value="" <?= isset($_GET['UserId']) ? '':'selected' ?> disabled>Select Employee</option>
                <?php foreach($users as $user): ?>
                    <option value="<?= $user['Id'] ?>" <?= (isset($_GET['UserId']) && $user['Id'] == $_GET['UserId']) ? 'selected':'' ?>><?= $user['Name'] ?></option>
                <?php endforeach; ?>
                </select>
            </div>
        </form>
        <form class="border rounded p-2 border-light" method="POST">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>Permission</th>
                        <th>VIEW</th>
                        <th>CREATE</th>
                        <th>MODIFY</th>
                        <th>DELETE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $modules = ['Department', 'Designation', 'User', 'Payroll', 'Project', 'Leaves', 'Client', 'Admin'];
                    ?>
                    <?php foreach($modules as $module): ?>
                    <tr>
                        <td><?= $module ?></td>
                        <td>
                            <input class="form-check-input" type="checkbox" value="<?= $moduleData[$module][0] != 'X' ? 'true' : 'false' ?>" />
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" value="<?= $moduleData[$module][1] != 'X' ? 'true' : 'false' ?>" />
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" value="<?= $moduleData[$module][2] != 'X' ? 'true' : 'false' ?>" />
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" value="<?= $moduleData[$module][3] != 'X' ? 'true' : 'false' ?>" />
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex flex-row-reverse">
                <button type="submit" name="submitP" value="submit" class="btn rounded-pill me-2 btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    function submitEmp(val) {
        console.log('asdad');
        window.location.href = '/addAdmin.php?UserId='+val;
        // document.getElementById('select-emp').submit();
    }
</script>