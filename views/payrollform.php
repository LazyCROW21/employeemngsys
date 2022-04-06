<?php
require_once "../models/users.php";
require_once "../config/dbconfig.php";
$paymentDone = false;
$duplicate = false;
$error = false;
$userModel = new UserModel($conn);
$users = $userModel->findAll();

if (isset($_POST['submitUser'])) {
    if(
        !isset($_POST['Name']) || !isset($_POST['Email']) ||
        !isset($_POST['Phone']) || !isset($_POST['DateOfBirth']) ||
        !isset($_POST['Gender']) || !isset($_POST['AddressL1']) ||
        !isset($_POST['AddressL2']) || !isset($_POST['City']) ||
        !isset($_POST['State']) || !isset($_POST['DepartmentId']) ||
        !isset($_POST['DesignationId']) || !isset($_POST['PAN']) ||
        !isset($_POST['BAN']) || !isset($_POST['Basic']) || !isset($_POST['DateOfJoining'])
    ) {
        exit("invalid input");
    }
    $_POST['Address'] = $_POST['AddressL1'].', '. $_POST['AddressL2'];
    unset($_POST['AddressL1']);
    unset($_POST['AddressL2']);
    if($result == 'success'){
        $paymentDone = true;
    } 
    elseif($result == 'duplicate') {
        $duplicate = true;
    }
    else {
        $error = true;
    }
}
?>
<h2 class="ps-2">Pay Staff</h2>
<hr>
<?php if($paymentDone): ?>
<div class="alert alert-success alert-dismissible" role="alert">
    User added succesfully!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif($duplicate): ?>
<div class="alert alert-warning alert-dismissible" role="alert">
    User not added, duplicate entry!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif($error): ?>
<div class="alert alert-danger alert-dismissible" role="alert">
    User cannot be added due to some error/invalid entry!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
<form class="border rounded p-2 border-light" method="POST">
    <div class="divider">
        <div class="divider-text">Staff Details</div>
    </div>
    <div class="mb-3">
        <div class="row">
            <div class="col-6 col-md-6">
                <label for="emp-select" class="col-form-label">Select Employee</label>
                <select id="emp-select" name="UserId" class="select2 form-control" data-allow-clear="true" required>
                    <?php foreach($users as $user): ?>
                    <option value="<?= $user['Id'] ?>"><?= $user['Name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6 col-md-6">
                <label for="emp-id" class="col-form-label">Employee Id</label>
                <input id="emp-id" type="text" class="form-control" value="101" disabled />
            </div>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-12 col-md-6">
            <label for="email-input" class="col-form-label">Email</label>
            <input class="form-control" type="email" value="john@example.com" id="email-input" disabled />
        </div>
        <div class="col-12 col-md-6">
            <label class="col-form-label">Phone</label>
            <input class="form-control" type="text" value="1233211230" pattern="^\d{10}" maxlength="10" disabled />
        </div>
    </div>
    <hr />
    <div class="mb-3 row">
        <div class="col-12 col-md-6">
            <label class="col-form-label">PAN</label>
            <input class="form-control" type="text" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" value="ASDFG1234Q" disabled />
        </div>
        <div class="col-12 col-md-6">
            <label class="col-form-label">Bank Acount Number</label>
            <input class="form-control" type="text" maxlength="18" pattern="^\d{9,18}$" value="123456789" disabled />
        </div>
    </div>
    <div class="divider">
        <div class="divider-text">Cost To Company</div>
    </div>
    <div class="mb-3 row">
        <div class="col-12 col-md-6">
            <p class="text-center"><strong>Earning</strong></p>
            <table class="table table-borderless">
                <tbody class="payslip-t">
                    <tr>
                        <td>Basic</td>
                        <td><input name="Basic" type="number" class="form-control text-end" value="50000" min="0" step="0.01" required /></td>
                    </tr>
                    <tr>
                        <td>House Rent Allowance</td>
                        <td><input name="HRA" type="number" class="form-control text-end" value="500" min="0" step="0.01" required /></td>
                    </tr>
                    <tr>
                        <td>Dearness Allowance</td>
                        <td><input name="DA" type="number" class="form-control text-end" value="500" min="0" step="0.01" required /></td>
                    </tr>
                    <tr>
                        <td>Travelling Allowance</td>
                        <td><input name="TA" type="number" class="form-control text-end" value="500" min="0" step="0.01" required /></td>
                    </tr>
                    <tr>
                        <td>Medical Allowance</td>
                        <td><input name="MA" type="number" class="form-control text-end" value="500" min="0" step="0.01" required /></td>
                    </tr>
                    <tr>
                        <td>Bonus</td>
                        <td><input name="Bonus" type="number" class="form-control text-end" value="500" min="0" step="0.01" required /></td>
                    </tr>
                    <tr>
                        <td>Overtime</td>
                        <td><input name="Overtime" type="number" class="form-control text-end" value="500" min="0" step="0.01" required /></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12 col-md-6">
            <p class="text-center"><strong>Deductions</strong></p>
            <table class="table table-borderless">
                <tbody class="payslip-t">
                    <tr>
                        <td>Income Tax</td>
                        <td><input name="IncomeTax" type="number" class="form-control text-end" value="400" min="0" step="0.01" required /></td>
                    </tr>
                    <tr>
                        <td>Professional Tax</td>
                        <td><input name="ProfessionalTax" type="number" class="form-control text-end" value="400" min="0" step="0.01" required /></td>
                    </tr>
                    <tr>
                        <td>Provident Fund</td>
                        <td><input name="PF" type="number" class="form-control text-end" value="400" min="0" step="0.01" required /></td>
                    </tr>
                    <td>Employees' State Insurance</td>
                    <td><input name="ESI" type="number" class="form-control text-end" value="400" min="0" step="0.01" required /></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mb-3">
        <table class="table table-borderless">
            <tbody class="text-end text-uppercase">
                <tr>
                    <td>
                        <strong>Total Earning:</strong>
                    </td>
                    <td>60000</td>
                </tr>
                <tr>
                    <td>
                        <strong>Total Deductions:</strong>
                    </td>
                    <td>20000</td>
                </tr>
                <tr>
                    <td>
                        <strong>NET Pay:</strong>
                    </td>
                    <td>40000</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="d-flex flex-row-reverse">
        <button type="submit" name="submitUser" value="submit" class="btn rounded-pill me-2 btn-primary">Submit</button>
        <button type="button" class="btn rounded-pill me-2 btn-secondary">Print</button>
    </div>
</form>

<script>
</script>