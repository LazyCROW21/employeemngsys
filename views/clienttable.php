<?php
require_once "../models/clients.php";
require_once "../config/dbconfig.php";

$clientModel = new ClientModel($conn);


$clientRemoved = false;
$error = false;
if(isset($_GET['remove'])) {  
  $result = $clientModel->removeById($_GET['remove']);
  if($result == 'deleted') {
    $deptRemoved = true;
  } else {
    $error = true;
  }
}


$rows = $clientModel->findAll();
?>

<h2 class="ps-2">All Clients</h2>
<hr>
<!-- table-responsive -->
<?php if($clientRemoved): ?>
<div class="alert alert-success alert-dismissible" role="alert">
  Client removed succesfully!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif($error): ?>
<div class="alert alert-danger alert-dismissible" role="alert">
  Error while processing the request!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
<div class="pt-0" style="overflow-x: auto; overflow-y: visible;">
    <table class="table table-hover border-top text-center" id="clienttable">
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
            <tr id="cr-<?= $row['Id'] ?>" data-client="<?= htmlentities(json_encode($row)) ?>">
                <td><?= $count++ ?></td>
                <td class="text-start"><?= $row['Name'] ?></td>
                <td><?= $row['State'] ?>, <?= $row['Country'] ?></td>
                <td><?= $row['NoOfProjects'] ?></td>
                <td><?= substr($row['CreatedAt'], 0, 10) ?></td>
                <td>
                    <?php if ($row['DeletedAt'] == null) : ?>
                    <div class="action-btn dropdown dropstart">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                                class="bx bx-dots-vertical-rounded"></i></button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#cModal"
                                onclick="setModal(<?= $row['Id'] ?>)">
                                <i class="bx bx-detail me-2"></i>Details
                            </button>
                            <a class="dropdown-item" href="/addClient.php?edit=<?= $row['Id'] ?>">
                                <i class="bx bx-edit-alt me-2"></i>Edit
                            </a>
                            <button class="dropdown-item" onclick="removeDept(<?= $row['Id'] ?>)">
                                <i class="bx bx-trash me-2"></i>Delete
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="cModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Client Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tbody id="mtbody">
                    </tbody>
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
        var row = document.getElementById('cr-' + id);
        var data = JSON.parse(row.getAttribute('data-client'));
        var tablebody = document.getElementById('mtbody');
        document.getElementById('mEdit').href = '/addClient.php?edit='+id;
        tablebody.innerHTML = '';
        for (const key in data) {
            tablebody.innerHTML += `<tr><td class="text-end fw-semibold">${key}</td><td>${data[key]}</td></tr>`;
        }
    }

    function removeDept(id) {
        if (!confirm('Are you sure you want to delete this client?')) {
        return;
        }
        window.location = '/viewClients.php?remove=' + id;
    }
</script>