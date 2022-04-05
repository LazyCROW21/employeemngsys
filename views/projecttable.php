<?php
require_once "../models/projects.php";
require_once "../config/dbconfig.php";

$projModel = new ProjectModel($conn);

$rows = $projModel->findAll();
?>

<h2 class="ps-2">All Projects</h2>
<hr>
<!-- table-responsive -->
<div class="pt-0" style="overflow-x: auto; overflow-y: visible;">
    <table class="table table-hover border-top text-center" id="projecttable">
        <thead>
            <tr>
                <th>#</th>
                <th class="text-start">Title</th>
                <th class="text-start">Client</th>
                <th class="text-start">Lead</th>
                <th>Deadline</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $currentDate = Date('Y-m-d');
            ?>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td class="text-start"><?= $row['Title'] ?></td>
                    <td class="text-start"><?= $row['ClientId'] ?></td>
                    <td class="text-start"><?= $row['LeadId'] ?></td>
                    <td><?= substr($row['Deadline'], 0, 10) ?></td>
                    <td>
                        <?php if ($row['Completed']) : ?>
                            <span class="badge bg-label-success me-1">Completed</span>
                        <?php elseif ($currentDate < $row['StartedAt']) : ?>
                            <span class="badge bg-label-secondary me-1">Scheduled</span>
                        <?php elseif ($currentDate > $row['Deadline']) : ?>
                            <span class="badge bg-label-danger me-1">Late</span>
                        <?php else : ?>
                            <span class="badge bg-label-primary me-1">Active</span>
                        <?php endif ?>
                    </td>
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