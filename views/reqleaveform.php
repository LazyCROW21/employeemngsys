<?php
require_once "../models/leaves.php";
require_once "../config/dbconfig.php";

$leaveAdded = false;
$duplicate = false;
$error = false;

if (isset($_POST['submitLeave'])) {
    if(
        !isset($_POST['LeaveType']) || !isset($_POST['EffectOnPay']) ||
        !isset($_POST['StartHalf']) || !isset($_POST['StartedAt']) || 
        !isset($_POST['EndHalf']) || !isset($_POST['EndedAt']) || !isset($_POST['Reason'])
    ) {
        exit("invalid input");
    }
    $_POST['UserId'] = $_SESSION['UserId'];
    $_POST['Status'] = 'Pending';
    $leaveModel = new LeaveModel($conn);
    $result = $leaveModel->insert($_POST);
    if($result == 'success') {
        $leaveAdded = true;
    } 
    elseif($result == 'duplicate') {
        $duplicate = true;
    }
    else {
        $error = true;
    }
}
?>
<h2 class="ps-2">Request a Leave</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-12 col-md-6 align-self-center">
        <?php if($leaveAdded): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            Leave added succesfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($duplicate): ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            Leave not added, duplicate entry!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($error): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            Leave cannot be added due to some error/invalid entry!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        <form class="border rounded p-2 border-light" method="POST">
            <div class="mb-3">
                <label for="name-input" class="col-form-label">Type of leave</label>
                <select name="LeaveType" class="select2 form-control" data-allow-clear="true" required>
                    <option value="Restricted Holiday">Restricted Holiday</option>
                    <option value="Vacation">Vacation</option>
                    <option value="Sick - Self">Sick - Self</option>
                    <option value="Sick - Family">Sick - Family</option>
                    <option value="Civil Duty">Civil Duty</option>
                    <option value="Funeral">Funeral</option>
                    <option value="Maternity">Maternity</option>
                    <option value="Parental">Parental</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="name-input" class="col-form-label">Effect on Pay</label><br />
                <div class="form-check form-check-inline mt-3">
                    <input name="EffectOnPay" class="form-check-input" type="radio" id="inlineCheckbox1"
                        value="Loss of Pay" required />
                    <label class="form-check-label" for="inlineCheckbox1">Loss of Pay</label>
                </div>
                <div class="form-check form-check-inline">
                    <input name="EffectOnPay" class="form-check-input" type="radio" id="inlineCheckbox2"
                        value="With Pay" required />
                    <label class="form-check-label" for="inlineCheckbox2">With Pay</label>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-12 col-form-label">From</label>
                <div class="col-12 col-md-6">
                    <select name="StartHalf" class="form-select" data-allow-clear="true" required>
                        <option value="M">Morning</option>
                        <option value="E">Evening</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <input name="StartedAt" class="form-control" type="date" value="" required />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-12 col-form-label">To</label>
                <div class="col-12 col-md-6">
                    <select name="EndHalf" class="form-select" data-allow-clear="true" required>
                        <option value="M">Morning</option>
                        <option value="E">Evening</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <input name="EndedAt" class="form-control" type="date" value="" required />
                </div>
            </div>
            <div class="mb-3">
                <label for="reason-input" class="col-form-label">Reason</label>
                <textarea name="Reason" class="form-control" type="text" placeholder="Enter reason here"
                    id="reason-input" required></textarea>
            </div>
            <div class="d-flex flex-row-reverse">
                <button type="submit" name="submitLeave" value="submit"
                    class="btn rounded-pill me-2 btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>