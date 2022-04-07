<?php
require_once "../models/permissions.php";
require_once "../config/dbconfig.php";

$pmModel = new PermissionModel($conn);

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
    <table class="table table-hover border-top text-center" id="projecttable">
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
            <tr>
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
                            <a class="dropdown-item" href="javascript:void(0);"><i
                                    class="bx bx-detail me-2"></i>Details</a>
                            <a class="dropdown-item" href="javascript:void(0);"><i
                                    class="bx bx-edit-alt me-2"></i>Edit</a>
                            <a class="dropdown-item" href="javascript:void(0);"><i
                                    class="bx bx-trash me-2"></i>Delete</a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>