<?php
require_once "../models/projects.php";
require_once "../models/projectEmp.php";
require_once "../config/dbconfig.php";

$projModel = new ProjectModel($conn);
$peModel = new ProjectEmpModel($conn);
$dropError = false;
$dropSuccess = false;
$completeError = false;
$completeSuccess = false;

if(isset($_GET['drop'])) {
    $result = $projModel->markDropped($_GET['drop']);
    if($result == 'success') {
        $dropSuccess = true;
    } else {
        $dropError = true;
    }
} else if(isset($_GET['complete'])) {
    $result = $projModel->markComplete($_GET['complete']);
    if($result == 'success') {
        $completeSuccess = true;
    } else {
        $completeError = true;
    }
}

$rows = $projModel->findAll();
?>

<h2 class="ps-2">All Projects</h2>
<hr>
<!-- table-responsive -->
<?php if($dropSuccess): ?>
<div class="alert alert-success alert-dismissible" role="alert">
  Project removed succesfully!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif($completeSuccess): ?>
<div class="alert alert-success alert-dismissible" role="alert">
    Project marked complete!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif($dropError || $completeError): ?>
<div class="alert alert-danger alert-dismissible" role="alert">
  Error while processing the request!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
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
            <?php
                $team = $peModel->findTeam($row['Id']); 
                $teamArr = array();
                foreach ($team as $member) {
                    array_push($teamArr, $member);
                }
            ?>
            <tr 
                id="pr-<?= $row['Id'] ?>" 
                data-project="<?= htmlentities(json_encode($row)) ?>" 
                data-team="<?= htmlentities(json_encode($teamArr)) ?>"
            >
                <td><?= $count++ ?></td>
                <td class="text-start"><?= $row['Title'] ?></td>
                <td class="text-start"><?= $row['ClientId'] ?></td>
                <td class="text-start"><?= $row['LeadId'] ?></td>
                <td><?= substr($row['Deadline'], 0, 10) ?></td>
                <td>
                    <?php if ($row['Completed']) : ?>
                    <span class="badge bg-label-success me-1">Completed</span>
                    <?php elseif (isset($row['DeletedAt'])) : ?>
                    <span class="badge bg-label-secondary me-1">Dropped</span>
                    <?php elseif (!$row['Deadline']) : ?>
                    <span class="badge bg-label-primary me-1">Active</span>
                    <?php elseif ($currentDate < $row['StartedAt']) : ?>
                    <span class="badge bg-label-info me-1">Scheduled</span>
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
                    <tbody id="mtbody-P"></tbody>
                </table>
                <div class="divider"><div class="divider-text">Team</div></div>
                <table class="table">
                    <thead id="mthead-T"></thead>
                    <tbody id="mtbody-T"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <a id="mDrop" class="btn link-danger" href="#">Drop</a>
                <a id="mComplete" class="btn link-success" href="#">Complete</a>
            </div>
        </div>
    </div>
</div>

<script>
    function setModal(id) {
        // for project
        var row = document.getElementById('pr-' + id);
        var data = JSON.parse(row.getAttribute('data-project'));
        var tablebodyP = document.getElementById('mtbody-P');
        document.getElementById('mDrop').href = '/viewProjects.php?drop='+id;
        document.getElementById('mComplete').href = '/viewProjects.php?complete='+id;
        tablebodyP.innerHTML = '';
        for (const key in data) {
            tablebodyP.innerHTML += `<tr><td class="text-end fw-semibold">${key}</td><td>${data[key]}</td></tr>`;
        }

        // for team
        var teamdata = JSON.parse(row.getAttribute('data-team'));
        var tablebodyT = document.getElementById('mtbody-T');
        var tableheadT = document.getElementById('mthead-T');
        var theadT = '';
        if(teamdata.length != 0) {
            theadT = '<tr><th>#</th>';
            for(const key in teamdata[0]) {
                theadT += `<th>${key}</th>`;
            }
            theadT += '</tr>';
        }
        tableheadT.innerHTML = theadT;
        var teamHTML = ''
        for (let i = 0; i < teamdata.length; i++) {
            let trStr = '<tr><td>'+(i+1)+'</td>';
            for(const key in teamdata[i]) {
                trStr += `<td>${teamdata[i][key]}</td>`;
            }
            trStr += '</tr>';
            teamHTML += trStr;
        }
        tablebodyT.innerHTML = teamHTML;
    }
</script>