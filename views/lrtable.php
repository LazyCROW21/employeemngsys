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
      <tr 
        id="lr-<?= $row['Id'] ?>"
        data-StartedAt="<?= $row['StartedAt'] ?>"
        data-StartHalf="<?= $row['StartHalf'] ?>"
        data-EndedAt="<?= $row['EndedAt'] ?>"
        data-EndHalf="<?= $row['EndHalf'] ?>"
        data-LeaveType="<?= $row['LeaveType'] ?>"
        data-EffectOnPay="<?= $row['EffectOnPay'] ?>"
        data-Reason="<?= $row['Reason'] ?>"
        data-Status="<?= $row['Status'] ?>"
        data-RespondedBy="<?= $row['RespondedBy'] ?>"
        data-RespondedAt="<?= $row['RespondedAt'] ?>"
        data-CreatedAt="<?= $row['CreatedAt'] ?>"
        data-RespondedByName="<?= $row['RespondedByName'] ?>"
      >
        <td><?= $count++ ?></td>
        <td class="text-start"><?= $row['LeaveType'] ?></td>
        <td><?= $row['EffectOnPay'] ?></td>
        <td><?= substr($row['StartedAt'], 0, 10) ?></td>
        <td><?= substr($row['EndedAt'], 0, 10) ?></td>
        <td>
          <div class="action-btn dropdown dropstart">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                class="bx bx-dots-vertical-rounded"></i></button>
            <div class="dropdown-menu">
              <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#lrModal"
                onclick="setModal(<?= $row['Id'] ?>)"><i class="bx bx-detail me-2"></i>Details</button>
            </div>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
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
              <td class="text-end fw-semibold">Status</td>
              <td id="mStatus"></td>
            </tr>
            <tr>
              <td class="text-end fw-semibold">Applied On</td>
              <td id="mCreatedAt"></td>
            </tr>
            <tr>
              <td class="text-end fw-semibold">Responded At</td>
              <td id="mRespondedAt"></td>
            </tr>
            <tr>
              <td class="text-end fw-semibold">Responded By</td>
              <td id="mRespondedByName"></td>
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
      </div>
    </div>
  </div>
</div>

<script>
  function setModal(id) {
    var row = document.getElementById('lr-' + id);
    var items = [ 'Status', 'StartedAt', 'StartHalf', 'EndedAt', 'EndHalf', 'LeaveType', 'EffectOnPay', 'Reason', 'Status', 'RespondedByName', 'RespondedAt', 'CreatedAt' ];
    for(let i=0; i<items.length; i++) {
      document.getElementById('m'+items[i]).innerText = row.getAttribute('data-'+items[i]);
    }
  }
</script>