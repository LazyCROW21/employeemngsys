<?php
require_once "../models/clients.php";
require_once "../config/dbconfig.php";

$deptModel = new ClientModel($conn);

$rows = $deptModel->findAll();
?>

<h2 class="ps-2">All Clients</h2>
<hr>
<!-- table-responsive -->
<div class="pt-0" style="overflow-x: auto; overflow-y: visible;">
    <table class="table table-hover border-top text-center" id="depttable">
        <thead>
            <tr>
                <th>#</th>
                <th class="text-start">Name</th>
                <th>Address</th>
                <th>Total Projects</th>
                <th>Since</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $currentDate = Date("Y-m-d");
            ?>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td class="text-start"><?= $row['Name'] ?></td>
                    <td><?= $row['State'] ?>, <?= $row['Country'] ?></td>
                    <td>1</td>
                    <td><?= substr($row['CreatedAt'], 0, 10) ?></td>
                    <td>
                        <div class="action-btn dropdown dropstart">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-detail me-2"></i>Details</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-2"></i>Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-2"></i>Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>