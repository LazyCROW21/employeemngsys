<?php
require_once "../models/permissions.php";
require_once "../config/dbconfig.php";

$pmModel = new PermissionModel($conn);

$modules = ['Department', 'Designation', 'User', 'Payroll', 'Project', 'Leaves', 'Client', 'Admin'];

$rows = $pmModel->findAll();

function countPermission($data) {
    $noOfP = 0;
    for($i = 0; $i < strlen($data['Department']); $i++) {
        if($data['Department'][$i] != 'X') $noOfP++;
    }
    for($i = 0; $i < strlen($data['Designation']); $i++) {
        if($data['Designation'][$i] != 'X') $noOfP++;
    }
    for($i = 0; $i < strlen($data['User']); $i++) {
        if($data['User'][$i] != 'X') $noOfP++;
    }
    for($i = 0; $i < strlen($data['Payroll']); $i++) {
        if($data['Payroll'][$i] != 'X') $noOfP++;
    }
    for($i = 0; $i < strlen($data['Project']); $i++) {
        if($data['Project'][$i] != 'X') $noOfP++;
    }
    for($i = 0; $i < strlen($data['Leaves']); $i++) {
        if($data['Leaves'][$i] != 'X') $noOfP++;
    }
    for($i = 0; $i < strlen($data['Client']); $i++) {
        if($data['Client'][$i] != 'X') $noOfP++;
    }
    for($i = 0; $i < strlen($data['Admin']); $i++) {
        if($data['Admin'][$i] != 'X') $noOfP++;
    }
    return $noOfP;
}

?>

<h2 class="ps-2">User Permissions</h2>
<hr>
<!-- table-responsive -->
<div class="pt-0" style="overflow-x: auto; overflow-y: visible;">
    <table class="table table-hover border-top text-center" id="permissiontable">
        <thead>
            <tr>
                <th>#</th>
                <th class="text-start">User</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Permissions</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $currentDate = Date('Y-m-d');
            ?>
            <?php if($rows): ?>
            <?php foreach ($rows as $row) : ?>
            <tr id="pr-<?= $row['UserId'] ?>" data-up="<?= urlencode(json_encode($row)) ?>">
                <td><?= $count++ ?></td>
                <td class="text-start"><?= $row['Name'] ?></td>
                <td><?= $row['DepartmentName'] ?></td>
                <td><?= $row['DesignationName'] ?></td>
                <td><?= countPermission($row) ?></td>
                <td>
                    <div class="action-btn dropdown dropstart">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                                class="bx bx-dots-vertical-rounded"></i></button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#pModal" onclick="setModal(<?= $row['UserId'] ?>)"><i
                                    class="bx bx-detail me-2"></i>Details</button>
                            <a class="dropdown-item" href="/addAdmin.php?UserId=<?= $row['UserId'] ?>"><i
                                    class="bx bx-edit-alt me-2"></i>Edit</a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="pModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span id="mTitle"></span>'s Permissions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                                <input id="<?= $module ?>-V" class="form-check-input" type="checkbox" disabled />
                            </td>
                            <td>
                                <input id="<?= $module ?>-C" class="form-check-input" type="checkbox" disabled />
                            </td>
                            <td>
                                <input id="<?= $module ?>-M" class="form-check-input" type="checkbox" disabled />
                            </td>
                            <td>
                                <input id="<?= $module ?>-D" class="form-check-input" type="checkbox" disabled />
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <a id="mEdit" type="button" class="btn btn-primary" href="#">Edit</a>
            </div>
        </div>
    </div>
</div>

<script>
    function setModal(id) {
        var row = document.getElementById('pr-'+id);
        var data = JSON.parse(decodeURIComponent(row.getAttribute('data-up')));
        document.getElementById('mTitle').innerText = data['Name'].replace(/\+/g, ' ');
        document.getElementById('mEdit').href = '/addAdmin.php?UserId='+id;
        
        var modules = ['Department', 'Designation', 'User', 'Payroll', 'Project', 'Leaves', 'Client', 'Admin'];
        var subModules = ['V', 'C', 'M', 'D'];
        for(let i=0; i<modules.length; i++) {
            for(let j=0; j<4; j++) {
                document.getElementById(modules[i]+'-'+subModules[j]).checked = (data[modules[i]][j] != 'X');
            }
        }

    }
</script>