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
            <tr id="pr-<?= $row['Id'] ?>" data-project="<?= htmlentities(json_encode($row)) ?>">
                <td><?= $count++ ?></td>
                <td class="text-start"><?= $row['Title'] ?></td>
                <td class="text-start"><?= $row['ClientId'] ?></td>
                <td class="text-start"><?= $row['LeadId'] ?></td>
                <td><?= substr($row['Deadline'], 0, 10) ?></td>
                <td>
                    <?php if ($row['Completed']) : ?>
                    <span class="badge bg-label-success me-1">Completed</span>
                    <?php elseif (!$row['Deadline']) : ?>
                    <span class="badge bg-label-primary me-1">Active</span>
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
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                                class="bx bx-dots-vertical-rounded"></i></button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#pModal" 
                                onclick="setModal(<?= $row['Id'] ?>)">
                                <i class="bx bx-detail me-2"></i>Details
                            </button>
                            <?php if($row['DeletedAt'] == null): ?>
                            <a class="dropdown-item" href="/addProject.php?edit=<?= $row['Id'] ?>">
                                <i class="bx bx-edit-alt me-2"></i>Edit
                            </a>
                            <button class="dropdown-item" href="javascript:void(0);">
                                <i class="bx bx-trash me-2"></i>Delete
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="pModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Project Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tbody id="mtbody"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <a id="mEdit" class="btn btn-primary" href="#">Edit</a>
            </div>
        </div>
    </div>
</div>

<script>
    function setModal(id) {
        var row = document.getElementById('pr-' + id);
        var data = JSON.parse(row.getAttribute('data-project'));
        var tablebody = document.getElementById('mtbody');
        document.getElementById('mEdit').href = '/addProject.php?edit='+id;
        tablebody.innerHTML = '';
        for (const key in data) {
            tablebody.innerHTML += `<tr><td class="text-end fw-semibold">${key}</td><td>${data[key]}</td></tr>`;
        }
    }
</script>