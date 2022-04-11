<?php
  require_once "../models/designations.php";
  require_once "../config/dbconfig.php";

  $desgModel = new DesgModel($conn);

  $desgRemoved = false;
  $error = false;
  if(isset($_GET['remove'])) {  
    $result = $desgModel->removeById($_GET['remove']);
    if($result == 'deleted') {
      $desgRemoved = true;
    } else {
      $error = true;
    }
  }
  
  $rows = $desgModel->findAll();
?>

<h2 class="ps-2">All Designations</h2>
<hr>
<?php if($desgRemoved): ?>
<div class="alert alert-success alert-dismissible" role="alert">
  Designation removed succesfully!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif($error): ?>
<div class="alert alert-danger alert-dismissible" role="alert">
  Error while processing the request!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
<div class="pt-0" style="overflow-x: auto; overflow-y: visible;">
  <table class="table table-hover border-top text-center" id="desgtable">
    <thead>
      <tr>
        <th class="text-start">#</th>
        <th class="text-start">Department</th>
        <th class="text-start">Designation</th>
        <th  class="text-start">Estd.</th>
        <th  class="text-start">Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $count = 1;
        $currentDate = Date('Y-m-d');
      ?>
      <?php foreach($rows as $row): ?>
      <tr>
        <td   class="text-start"><?= $count++ ?></td>
        <td class="text-start"><?= $row['Department'] ?></td>
        <td class="text-start"><?= $row['Designation'] ?></td>
        <td   class="text-start"><?= substr($row['CreatedAt'], 0, 10) ?></td>
        <td   class="text-start">
          <?php if($row['DeletedAt'] == null): ?>
          <span class="badge bg-label-primary me-1">Active</span>
          <?php else: ?>
          <span class="badge bg-label-secondary me-1">Terminated</span>
          <?php endif ?>
        </td>
        <td>
          <?php if ($row['DeletedAt'] == null) : ?>
          <div class="action-btn dropdown dropstart">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                class="bx bx-dots-vertical-rounded"></i></button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="/addDesg.php?edit=<?= $row['Id'] ?>"><i class="bx bx-edit-alt me-2"></i>Edit</a>
              <button class="dropdown-item" onclick="removeDesg(<?= $row['Id'] ?>)"><i class="bx bx-trash me-2"></i>Delete</button>
            </div>
          </div>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>

<script>
  function removeDesg(id) {
    if (!confirm('Are you sure you want to delete this designation?')) {
      return;
    }
    window.location = '/viewDesg.php?remove=' + id;
  }
</script>