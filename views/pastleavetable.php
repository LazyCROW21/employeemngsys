<?php
require_once "../models/leaves.php";
require_once "../config/dbconfig.php";

$leaveModel = new LeaveModel($conn);

$rows = $leaveModel->findPastLeaves();
?>

<h2 class="ps-2">Past Leave Requests</h2>
<hr>
<div class="pt-0" style="overflow-x: auto; overflow-y: visible;">
  <table class="table table-hover text-center border-top" id="leavestable">
    <thead>
      <tr>
        <th>#</th>
        <th class="text-start">Employee Name (ID)</th>
        <th>Leave Type</th>
        <th>Effect On Pay</th>
        <th>Status</th>
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
        <td class="text-start"><?= $row['UserId'] ?></td>
        <td class="text-start"><?= $row['LeaveType'] ?></td>
        <td class="text-start"><?= $row['EffectOnPay'] ?></td>
        <td>
          <?php if($row['Status'] == 'Rejected'): ?>
          <span class="badge bg-label-danger me-1">Rejected</span>
          <?php else: ?>
          <span class="badge bg-label-success me-1">Approved</span>
          <?php endif ?>
        </td>
        <td><?= substr($row['StartedAt'], 0, 10) ?></td>
        <td><?= substr($row['EndedAt'], 0, 10) ?></td>
        <td>
          <div class="action-btn dropdown dropstart">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                class="bx bx-dots-vertical-rounded"></i></button>
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