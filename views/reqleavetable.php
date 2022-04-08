<?php
require_once "../models/leaves.php";
require_once "../config/dbconfig.php";

$leaveModel = new LeaveModel($conn);

$operation = false;
$error = false;

if(isset($_POST['reject'])) {
  $operation = 'Rejected';
  $data = [
    'RespondedBy' => $_SESSION['UserId'],
    'Id' => $_POST['reject']
  ];
  $result = $leaveModel->reviewLeave($data, 'Rejected');
  if(!$result) {
    $error = true;
  }
} else if(isset($_POST['approve'])) {
  $operation = 'Approved';
  $data = [
    'RespondedBy' => $_SESSION['UserId'],
    'Id' => $_POST['approve']
  ];
  $result = $leaveModel->reviewLeave($data, 'Approved');
  if(!$result) {
    $error = true;
  }
}

$rows = $leaveModel->findPendingLeaves();
?>

<h2 class="ps-2">New Leave Requests</h2>
<hr>
<div class="pt-0" style="overflow-x: auto; overflow-y: visible;">

  <?php if($operation): ?>
  <div class="alert alert-success alert-dismissible" role="alert">
    Leave succesfully <?= $operation ?>!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php elseif($error): ?>
  <div class="alert alert-danger alert-dismissible" role="alert">
    Leave cannot be <?= $operation ?> due to some error/invalid entry!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php endif; ?>

  <?php if ($rows == NULL): ?>
  <h5 class="text-center">No new leave Requests!</h5>
  <?php endif; ?>

  <?php if ($rows != NULL): ?>
  <table class="table table-hover text-center border-top" id="leavestable">
    <thead>
      <tr>
        <th>#</th>
        <th class="text-start">Employee Name</th>
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
      <tr id="lr-<?= $row['Id'] ?>" data-UserName="<?= $row['UserName'] ?>"
        data-StartedAt="<?= substr($row['StartedAt'], 0, 10) ?>" data-StartHalf="<?= $row['StartHalf'] ?>"
        data-EndedAt="<?= substr($row['EndedAt'], 0, 10) ?>" data-EndHalf="<?= $row['EndHalf'] ?>"
        data-LeaveType="<?= $row['LeaveType'] ?>" data-EffectOnPay="<?= $row['EffectOnPay'] ?>"
        data-Reason="<?= $row['Reason'] ?>" data-Status="<?= $row['Status'] ?>"
        data-CreatedAt="<?= substr($row['CreatedAt'], 0, 16) ?>">
        <td><?= $count++ ?></td>
        <td class="text-start"><?= $row['UserName'] ?></td>
        <td><?= $row['LeaveType'] ?></td>
        <td><?= $row['EffectOnPay'] ?></td>
        <td><?= substr($row['StartedAt'], 0, 10) ?></td>
        <td><?= substr($row['EndedAt'], 0, 10) ?></td>
        <td>
          <div class="action-btn dropdown dropstart">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                class="bx bx-dots-vertical-rounded"></i></button>
            <div class="dropdown-menu">
              <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#lrModal"
                onclick="setModal(<?= $row['Id'] ?>)"><i class="bx bx-edit-alt me-2"></i>Review</button>
            </div>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>


<!-- Modal -->
<div class="modal fade" id="lrModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Application Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table">
          <tbody>
            <tr>
              <td class="text-end fw-semibold">Applied By</td>
              <td id="mUserName"></td>
            </tr>
            <tr>
              <td class="text-end fw-semibold">Status</td>
              <td id="mStatus"></td>
            </tr>
            <tr>
              <td class="text-end fw-semibold">Applied On</td>
              <td id="mCreatedAt"></td>
            </tr>
            <tr>
              <td class="text-end fw-semibold">Leave Type</td>
              <td id="mLeaveType"></td>
            </tr>
            <tr>
              <td class="text-end fw-semibold">Effect On Pay</td>
              <td id="mEffectOnPay"></td>
            </tr>
            <tr>
              <td class="text-end fw-semibold">Start Half</td>
              <td id="mStartHalf"></td>
            </tr>
            <tr>
              <td class="text-end fw-semibold">Started At</td>
              <td id="mStartedAt"></td>
            </tr>
            <tr>
              <td class="text-end fw-semibold">End Half</td>
              <td id="mEndHalf"></td>
            </tr>
            <tr>
              <td class="text-end fw-semibold">Ended At</td>
              <td id="mEndedAt"></td>
            </tr>
            <tr>
              <td class="text-end fw-semibold">Reason</td>
              <td id="mReason"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        <form method="POST">
          <button id="mRejectId" type="submit" name="reject" value=""
            class="btn btn-label-danger text-danger">Reject</button>
        </form>
        <form method="POST">
          <button id="mApproveId" type="submit" name="approve" value=""
            class="btn btn-label-success text-success">Approve</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function setModal(id) {
    var row = document.getElementById('lr-' + id);
    var items = [
      'Status', 'StartedAt', 'StartHalf', 'EndedAt', 'EndHalf', 'LeaveType', 'EffectOnPay', 'Reason', 'UserName',
      'CreatedAt'
    ];
    for (let i = 0; i < items.length; i++) {
      document.getElementById('m' + items[i]).innerText = row.getAttribute('data-' + items[i]);
    }
    document.getElementById('mRejectId').value = id;
    document.getElementById('mApproveId').value = id;
  }
</script>