<?php
require_once "../models/users.php";
require_once "../models/permissions.php";
require_once "../config/dbconfig.php";
$updateSuccess = false;
$duplicate = false;
$error = false;
$userModel = new UserModel($conn);
$users = $userModel->findAll();

$prModel = new PermissionModel($conn);
$editFlag = false;

$modules = ['Department', 'Designation', 'User', 'Payroll', 'Project', 'Leaves', 'Client', 'Admin'];

$pDepartment = 'XXXX';
$pDesignation = 'XXXX';
$pUser = 'XXXX';
$pPayroll = 'XXXX';
$pProject = 'XXXX';
$pLeaves = 'XXXX';
$pClient = 'XXXX';
$pAdmin = 'XXXX';

if (isset($_POST['submitP']) && isset($_GET['UserId']) && $_GET['UserId'] != $_SESSION['UserId']) {
    $data = array();
    foreach($modules as $module) {
        $perm = '';
        if(isset($_POST[$module.'-V'])) {
            $perm .= 'V';
        } else {
            $perm .= 'X';
        }
        if(isset($_POST[$module.'-C'])) {
            $perm .= 'C';
        } else {
            $perm .= 'X';
        }
        if(isset($_POST[$module.'-M'])) {
            $perm .= 'M';
        } else {
            $perm .= 'X';
        }
        if(isset($_POST[$module.'-D'])) {
            $perm .= 'D';
        } else {
            $perm .= 'X';
        }
        $data[$module] = $perm;
    }
    $data['UserId'] = $_GET['UserId'];
    $result = $prModel->update($data);
    echo $result;
    if($result == 'success') {
        $updateSuccess = true;
    } else if($result == 'duplicate') {
        $duplicate = true;
    } else {
        $error = true;
    }
}
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

?>
<h2 class="ps-2">Give Permission</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-12 col-md-8 align-self-center">
        <?php if($updateSuccess): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            Permissions updated succesfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($duplicate): ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            Permissions not updated, duplicate entry!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($error): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            Permissions cannot be updated due to some error/invalid entry!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        <form id="select-emp" class="border rounded p-2 border-light mb-3" method="GET">
            <div class="mb-3">
                <label for="name-input" class="col-form-label">Select Employee</label>
                <select class="select2 form-control" data-allow-clear="true" onchange="submitEmp(this.value)">
                    <option value="" <?= isset($_GET['UserId']) ? '':'selected' ?> disabled>Select Employee</option>
                    <?php foreach($users as $user): ?>
                    <?php if($user['Id'] != $_SESSION['UserId']): ?>
                    <option value="<?= $user['Id'] ?>" <?= (isset($_GET['UserId']) && $user['Id'] == $_GET['UserId']) ? 'selected':'' ?>><?= $user['Name'] ?></option>
                    <?php endif; ?>
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
                    <?php foreach($modules as $module): ?>
                    <tr>
                        <td><?= $module ?></td>
                        <td>
                            <input name="<?= $module ?>-V" class="form-check-input" type="checkbox"
                                <?= $moduleData[$module][0] !== 'X' ? 'checked' : '' ?> />
                        </td>
                        <td>
                            <input name="<?= $module ?>-C" class="form-check-input" type="checkbox"
                                <?= $moduleData[$module][1] !== 'X' ? 'checked' : '' ?> />
                        </td>
                        <td>
                            <input name="<?= $module ?>-M" class="form-check-input" type="checkbox"
                                <?= $moduleData[$module][2] !== 'X' ? 'checked' : '' ?> />
                        </td>
                        <td>
                            <input name="<?= $module ?>-D" class="form-check-input" type="checkbox"
                                <?= $moduleData[$module][3] !== 'X' ? 'checked' : '' ?> />
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex flex-row-reverse">
                <button type="submit" name="submitP" value="submit"
                    class="btn rounded-pill me-2 btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    function submitEmp(val) {
        console.log('asdad');
        window.location.href = '/addAdmin.php?UserId=' + val;
        // document.getElementById('select-emp').submit();
    }
</script>