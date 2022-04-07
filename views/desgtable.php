<?php
  require_once "../models/designations.php";
  require_once "../config/dbconfig.php";

  $desgModel = new DesgModel($conn);

  $rows = $desgModel->findAll();
?>

<h2 class="ps-2">All Designations</h2>
<hr>
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
        <!-- <td><?= $row['Id'] ?></td> -->
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
        <td   class="text-start">
          <div class="action-btn dropdown dropstart">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                class="bx bx-dots-vertical-rounded"></i></button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-2"></i>Edit</a>
              <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-2"></i>Delete</a>
            </div>
          </div>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>