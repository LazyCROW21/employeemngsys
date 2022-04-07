<?php
require_once "../models/users.php";
require_once "../models/payrolls.php";
require_once "../config/dbconfig.php";
$paymentDone = false;
$duplicate = false;
$error = false;
$userModel = new UserModel($conn);
$users = $userModel->findAllActive();

$months = [
    ['Id' => 1, 'Name' => 'January'],
    ['Id' => 2, 'Name' => 'Febuary'],
    ['Id' => 3, 'Name' => 'March'],
    ['Id' => 4, 'Name' => 'April'],
    ['Id' => 5, 'Name' => 'May'],
    ['Id' => 6, 'Name' => 'June'],
    ['Id' => 7, 'Name' => 'July'],
    ['Id' => 8, 'Name' => 'August'],
    ['Id' => 9, 'Name' => 'September'],
    ['Id' => 10, 'Name' => 'October'],
    ['Id' => 11, 'Name' => 'November'],
    ['Id' => 12, 'Name' => 'December']
];
$currM = Date('m');
$currY = Date('Y');

$years = [
    ['Id' => 2021, 'Name' => '2021'],
    ['Id' => 2022, 'Name' => '2022'],
    ['Id' => 2023, 'Name' => '2023'],
    ['Id' => 2024, 'Name' => '2024'],
    ['Id' => 2025, 'Name' => '2025']
];

if (isset($_POST['submitPayroll'])) {
    if(
        !isset($_POST['UserId']) || !isset($_POST['Email']) || !isset($_POST['Phone']) || 
        !isset($_POST['UserName']) || !isset($_POST['Department']) || !isset($_POST['Designation']) ||
        !isset($_POST['PAN']) || !isset($_POST['BAN']) || !isset($_POST['Month']) ||
        !isset($_POST['Year']) || !isset($_POST['Basic']) || !isset($_POST['HRA']) ||
        !isset($_POST['DA']) || !isset($_POST['TA']) || !isset($_POST['MA']) || 
        !isset($_POST['Bonus']) || !isset($_POST['Overtime']) || !isset($_POST['IncomeTax']) || 
        !isset($_POST['ProfessionalTax']) || !isset($_POST['PF']) || !isset($_POST['ESI'])
    ) {
        exit("invalid input");
    }
    $_POST['GrantedBy'] = $_SESSION['UserId'];
    $prModel = new PRModel($conn);
    $result = $prModel->insert($_POST);
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
    Pay slip generate succesfully!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif($duplicate): ?>
<div class="alert alert-warning alert-dismissible" role="alert">
    Duplicate entry!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif($error): ?>
<div class="alert alert-danger alert-dismissible" role="alert">
    Pay slip cannot be generate due to some error/invalid entry!
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
                <input name="UserName" type="hidden" id="emp-name" />
                <select id="emp-select" name="UserId" class="select2 form-control" data-allow-clear="true"
                    onchange="getUserDetails(this.value)" required>
                    <option selected readonly>Select an Employee</option>
                    <?php foreach($users as $user): ?>
                    <option value="<?= $user['Id'] ?>"><?= $user['Name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6 col-md-6">
                <label for="emp-id" class="col-form-label">Employee Id</label>
                <input id="emp-id" type="text" class="form-control" readonly />
            </div>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-12 col-md-6">
            <label for="email-input" class="col-form-label">Email</label>
            <input name="Email" class="form-control" type="email" id="emp-email" readonly />
        </div>
        <div class="col-12 col-md-6">
            <label class="col-form-label">Phone</label>
            <input name="Phone" class="form-control" type="text" id="emp-phone" readonly />
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-12 col-md-6">
            <label class="col-form-label">Department</label>
            <input name="Department" class="form-control" type="text" id="emp-dept" readonly />
        </div>
        <div class="col-12 col-md-6">
            <label class="col-form-label">Designation</label>
            <input name="Designation" class="form-control" type="text" id="emp-desg" readonly />
        </div>
    </div>
    <hr />
    <div class="mb-3 row">
        <div class="col-12 col-md-6">
            <label class="col-form-label">PAN</label>
            <input name="PAN" class="form-control" type="text" id="emp-pan" readonly />
        </div>
        <div class="col-12 col-md-6">
            <label class="col-form-label">Bank Acount Number</label>
            <input name="BAN" class="form-control" type="text" maxlength="18" id="emp-ban" readonly />
        </div>
    </div>
    <div class="divider">
        <div class="divider-text">Cost To Company</div>
    </div>
    <div class="mb-3 row">
        <div class="col-12 col-md-6">
            <label id="month-select" class="col-form-label">Month</label>
            <select id="month-select" name="Month" class="select2 form-control" data-allow-clear="true" required>
                <?php foreach($months as $month): ?>
                <option value="<?= $month['Id'] ?>" <?= $currM == $month['Id'] ? 'selected' : '' ?>>
                    <?= $month['Name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12 col-md-6">
            <label for="year-select" class="col-form-label">Year</label>
            <select id="year-select" name="Year" class="select2 form-control" data-allow-clear="true" required>
                <?php foreach($years as $year): ?>
                <option value="<?= $year['Id'] ?>" <?= $currY == $year['Id'] ? 'selected' : '' ?>><?= $year['Name'] ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-12 col-md-6">
            <p class="text-center"><strong>Earning</strong></p>
            <table class="table table-borderless">
                <tbody id="earningSide" class="payslip-t">
                    <tr>
                        <td>Basic</td>
                        <td><input name="Basic" type="number" class="form-control text-end" value="50000" min="0"
                                step="0.01" oninput="update()" id="emp-basic" required /></td>
                    </tr>
                    <tr>
                        <td>House Rent Allowance</td>
                        <td><input name="HRA" type="number" class="form-control text-end" value="500" min="0"
                                step="0.01" oninput="update()" required /></td>
                    </tr>
                    <tr>
                        <td>Dearness Allowance</td>
                        <td><input name="DA" type="number" class="form-control text-end" value="500" min="0" step="0.01"
                                oninput="update()" required /></td>
                    </tr>
                    <tr>
                        <td>Travelling Allowance</td>
                        <td><input name="TA" type="number" class="form-control text-end" value="500" min="0" step="0.01"
                                oninput="update()" required /></td>
                    </tr>
                    <tr>
                        <td>Medical Allowance</td>
                        <td><input name="MA" type="number" class="form-control text-end" value="500" min="0" step="0.01"
                                oninput="update()" required /></td>
                    </tr>
                    <tr>
                        <td>Bonus</td>
                        <td><input name="Bonus" type="number" class="form-control text-end" value="500" min="0"
                                step="0.01" oninput="update()" required /></td>
                    </tr>
                    <tr>
                        <td>Overtime</td>
                        <td><input name="Overtime" type="number" class="form-control text-end" value="500" min="0"
                                step="0.01" oninput="update()" required /></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12 col-md-6">
            <p class="text-center"><strong>Deductions</strong></p>
            <table class="table table-borderless">
                <tbody class="payslip-t" id="dedcSide">
                    <tr>
                        <td>Income Tax</td>
                        <td><input name="IncomeTax" type="number" class="form-control text-end" value="400" min="0"
                                step="0.01" oninput="update()" required /></td>
                    </tr>
                    <tr>
                        <td>Professional Tax</td>
                        <td><input name="ProfessionalTax" type="number" class="form-control text-end" value="400"
                                min="0" step="0.01" oninput="update()" required /></td>
                    </tr>
                    <tr>
                        <td>Provident Fund</td>
                        <td><input name="PF" type="number" class="form-control text-end" value="400" min="0" step="0.01"
                                oninput="update()" required /></td>
                    </tr>
                    <td>Employees' State Insurance</td>
                    <td><input name="ESI" type="number" class="form-control text-end" value="400" min="0" step="0.01"
                            oninput="update()" required /></td>
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
                    <td id="totalEarn"></td>
                </tr>
                <tr>
                    <td>
                        <strong>Total Deductions:</strong>
                    </td>
                    <td id="totalDedc"></td>
                </tr>
                <tr>
                    <td>
                        <strong>NET Pay:</strong>
                    </td>
                    <td id="netPay"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="d-flex flex-row-reverse">
        <button type="submit" name="submitPayroll" value="submit"
            class="btn rounded-pill me-2 btn-primary">Submit</button>
        <button type="button" class="btn rounded-pill me-2 btn-secondary">Print</button>
    </div>
</form>

<script>
    function getUserDetails(id) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let dataObj = JSON.parse(this.responseText);
                console.log(dataObj);
                if(!dataObj) {
                    return;
                }
                document.getElementById('emp-name').value = dataObj['Name'];
                document.getElementById('emp-basic').value = dataObj['Basic'];
                document.getElementById('emp-id').value = dataObj['Id'];
                document.getElementById('emp-pan').value = dataObj['PAN'];
                document.getElementById('emp-ban').value = dataObj['BAN'];
                document.getElementById('emp-phone').value = dataObj['Phone'];
                document.getElementById('emp-email').value = dataObj['Email'];
                document.getElementById('emp-dept').value = dataObj['Department'];
                document.getElementById('emp-desg').value = dataObj['Designation'];
            }
        };
        xhttp.open("GET", "/api/user.php?Id=" + id, true);
        xhttp.send();
    }

    function update() {
        setTotalEarn();
        setTotalDedc();
        setNetPay();
    }

    function setTotalEarn() {
        var te = document.getElementById('totalEarn');
        var es = document.getElementById('earningSide').getElementsByTagName('input');
        var totalEarn = 0;
        for (let i = 0; i < es.length; i++) {
            totalEarn += parseFloat(es[i].value);
        }
        te.innerHTML = totalEarn.toFixed(2);
    }

    function setTotalDedc() {
        var td = document.getElementById('totalDedc');
        var ds = document.getElementById('dedcSide').getElementsByTagName('input');
        var totalDedc = 0;
        for (let i = 0; i < ds.length; i++) {
            totalDedc += parseFloat(ds[i].value);
        }
        td.innerHTML = totalDedc.toFixed(2);
    }

    function setNetPay() {
        var np = document.getElementById('netPay');
        var te = document.getElementById('totalEarn');
        var td = document.getElementById('totalDedc');
        np.innerHTML = (parseFloat(te.innerHTML) - parseFloat(td.innerHTML)).toFixed(2);
    }

    update();
</script>