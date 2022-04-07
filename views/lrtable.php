<?php
require_once "../models/leaves.php";
require_once "../config/dbconfig.php";

$leaveModel = new LeaveModel($conn);
$rows = $leaveModel->findPastLeavesByUserId($_SESSION['UserId']);
?>

<h2 class="ps-2">Leaves Report</h2>
<hr>
<div class="pt-0" style="overflow-x: auto; overflow-y: visible;">
  <table class="table table-hover text-center border-top" id="leavestable">
    <thead>
      <tr>
        <th>#</th>
        <th>Leave Type</th>
        <th>Effect On Pay</th>
        <th>From</th>
        <th>To</th>
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
          <td class="text-start"><?= $row['LeaveType'] ?></td>
          <td><?= $row['EffectOnPay'] ?></td>
          <td><?= substr($row['StartedAt'], 0, 10) ?></td>
          <td><?= substr($row['EndedAt'], 0, 10) ?></td>
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