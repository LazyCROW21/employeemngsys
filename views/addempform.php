<?php
require_once "../models/departments.php";
require_once "../models/designations.php";
require_once "../models/users.php";
require_once "../config/dbconfig.php";
$userAdded = false;
$duplicate = false;
$error = false;
$editFlag = false;
$userUpdate = false;
$editUser = array();

$deptModel = new DeptModel($conn);
$desgModel = new DesgModel($conn);
$userModel = new UserModel($conn);
$departments = $deptModel->findAllActive();
$designations = $desgModel->findAllActive();

$states = ['Andaman and Nicobar', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', ' Chandigarh', 'Chhattisgarh', 'Dadra and Nagar Haveli', 'Daman and Diu', 'Delhi', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jammu and Kashmir', 'Jharkhand', 'Karnataka    ', 'Kerala', 'Lakshadweep', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Orissa', 'Puducherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal'];

if (isset($_POST['submitUser'])) {
    if(
        !isset($_POST['Name']) || !isset($_POST['Email']) ||
        !isset($_POST['Phone']) || !isset($_POST['DateOfBirth']) ||
        !isset($_POST['Gender']) || !isset($_POST['DateOfJoining']) ||
        !isset($_POST['Address']) || !isset($_POST['City']) ||
        !isset($_POST['State']) || !isset($_POST['DepartmentId']) ||
        !isset($_POST['DesignationId']) || !isset($_POST['PAN']) ||
        !isset($_POST['BAN']) || !isset($_POST['Basic']) 
    ) {
        $error = true;
    } else {
        if(isset($_GET['edit'])) {
            $_POST['Id'] = $_GET['edit'];
            $result = $userModel->update($_POST);
            if($result == 'success'){
                $userUpdate = true;
            } 
            elseif($result == 'duplicate') {
                $duplicate = true;
            }
            else {
                $error = true;
            }
        }
        else {
            $_POST['CreatedBy'] = $_SESSION['UserId'];
            $result = $userModel->insert($_POST);
            if($result == 'success'){
                $userAdded = true;
            } 
            elseif($result == 'duplicate') {
                $duplicate = true;
            }
            else {
                $error = true;
            }
        }
    }
}

if (isset($_GET['edit'])) {
    $editFlag = true;
    $editUser = $userModel->findById($_GET['edit']);
}

?>
<?php if($editFlag): ?>
<h2 class="ps-2">Edit Staff</h2>
<?php else: ?>
<h2 class="ps-2">Add Staff</h2>
<?php endif; ?>
<hr>
<?php if($userAdded): ?>
<div class="alert alert-success alert-dismissible" role="alert">
    User added succesfully!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif($duplicate): ?>
<div class="alert alert-warning alert-dismissible" role="alert">
    User not added, duplicate entry!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif($userUpdate): ?>
<div class="alert alert-success alert-dismissible" role="alert">
    User update successful!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif($error && $editFlag): ?>
<div class="alert alert-danger alert-dismissible" role="alert">
    User cannot be updated due to some error/invalid entry!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php elseif($error && !$editFlag): ?>
<div class="alert alert-danger alert-dismissible" role="alert">
    User cannot be added due to some error/invalid entry!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
<form class="border rounded p-2 border-light" method="POST">
    <div class="divider">
        <div class="divider-text">Personal Details</div>
    </div>
    <div class="mb-3">
        <label for="name-input" class="col-form-label">Name</label>
        <input name="Name" class="form-control" type="text" value="<?= isset($editUser['Name']) ? $editUser['Name'] : '' ?>" placeholder="Enter name here" id="name-input" maxlength="50" required/>
    </div>
    <div class="mb-3 row">
        <div class="col-12 col-md-6">
            <label for="email-input" class="col-form-label">Email</label>
            <input name="Email" class="form-control" type="email" value="<?= isset($editUser['Email']) ? $editUser['Email'] : '' ?>" placeholder="john@example.com" id="email-input" required/>
        </div>
        <div class="col-12 col-md-6">
            <label for="phone-input" class="col-form-label">Phone</label>
            <input name="Phone" class="form-control" type="text" value="<?= isset($editUser['Phone']) ? $editUser['Phone'] : '' ?>" pattern="^\d{10}" id="phone-input" maxlength="10" required/>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-12 col-md-6">
            <label for="dob-input" class="col-form-label">Date Of Birth</label>
            <input name="DateOfBirth" class="form-control" value="<?= isset($editUser['DateOfBirth']) ? $editUser['DateOfBirth'] : '' ?>" type="date" value="" id="dob-input" required/>
        </div>
        <div class="col-12 col-md-6">
            <label class="col-form-label">Gender</label>
            <br />
            <?php
                $gender = isset($editUser['Gender']) ? $editUser['Gender'] : '';
            ?>
            <div class="form-check form-check-inline">
                <input name="Gender" class="form-check-input" type="radio" value="M" <?= $gender == 'M' ? 'checked': '' ?> id="genderMale" required/>
                <label class="form-check-label" for="genderMale">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input name="Gender" class="form-check-input" type="radio" value="F" <?= $gender == 'F' ? 'checked': '' ?> id="genderFemale" required/>
                <label class="form-check-label" for="genderFemale">Female</label>
            </div>
            <div class="form-check form-check-inline">
                <input name="Gender" class="form-check-input" type="radio" value="O" <?= $gender == 'O' ? 'checked': '' ?> id="genderOther" required/>
                <label class="form-check-label" for="genderOther">Other</label>
            </div>
        </div>

    </div>
    <div class="mb-3 row">
        <label class="col-12 col-form-label">Permanent Address</label>
        <div class="col-12 mb-3">
            <input name="Address" class="form-control" type="text" placeholder="Address Line" value="<?= isset($editUser['Address']) ? $editUser['Address'] : '' ?>"  maxlength="510" required />
        </div>
        <div class="col-12 col-md-6">
            <input name="City" class="form-control" type="text" value="<?= isset($editUser['City']) ? $editUser['City'] : '' ?>" maxlength="50" placeholder="City" required/>
        </div>
        <div class="col-12 col-md-6">
            <select name="State" class="select2 form-control" data-allow-clear="true" required>
            <?php foreach($states as $state): ?>
                <?php if(isset($editUser['State']) && $state == $editUser['State']): ?>
                <option value="<?= $state ?>" selected><?= $state ?></option>
                <?php else: ?>
                <option value="<?= $state ?>"><?= $state ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="divider">
        <div class="divider-text">Professional Details</div>
    </div>
    <div class="mb-3 row">
        <label class="col-12 col-form-label">Position</label>
        <div class="col-12 col-md-6 mb-3">
            <select id="dept-select" name="DepartmentId" class="select2 form-control" data-allow-clear="true" oninput="setDesg()">
            <?php foreach($departments as $department): ?>
                <?php if(isset($editUser['DepartmentId']) && $department['Id'] == $editUser['DepartmentId']): ?>
                <option value="<?= $department['Id'] ?>" selected><?= $department['Name'] ?></option>
                <?php else: ?>
                <option value="<?= $department['Id'] ?>"><?= $department['Name'] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12 col-md-6">
            <select id="desg-select" class="select2 form-control" name="DesignationId" data-allow-clear="true"></select>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-12 col-md-6">
            <label for="pan-input" class="col-form-label">PAN</label>
            <input name="PAN" class="form-control" type="text" value="<?= isset($editUser['PAN']) ? $editUser['PAN'] : '' ?>" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" placeholder="Enter PAN" id="pan-input" required/>
        </div>
        <div class="col-12 col-md-6">
            <label for="bank-input" class="col-form-label">Bank Acount Number</label>
            <input name="BAN" class="form-control" type="text" value="<?= isset($editUser['BAN']) ? $editUser['BAN'] : '' ?>" maxlength="18" pattern="^\d{9,18}$" placeholder="Enter bank Acc number" id="bank-input" required/>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-12 col-md-6">
            <label for="salary-input" class="col-form-label">Basic Salary (in Rs.)</label>
            <input name="Basic" class="form-control" type="number" value="<?= isset($editUser['Basic']) ? $editUser['Basic'] : '' ?>" min="0" step="0.01" placeholder="500000" id="salary-input" required />
        </div>
        <div class="col-12 col-md-6">
            <label for="date-input" class="col-form-label">Date Of Joining</label>
            <input name="DateOfJoining" class="form-control" value="<?= isset($editUser['DateOfJoining']) ? $editUser['DateOfJoining'] : '' ?>" type="date" value="" id="date-input" required />
        </div>
    </div>
    <div class="d-flex flex-row-reverse">
        <button type="submit" name="submitUser" value="submit" class="btn rounded-pill me-2 btn-primary">Submit</button>
    </div>
</form>

<script>
var designations = [
<?php foreach($designations as $designation): ?>
{ id:<?= $designation['Id'] ?>, deptId: '<?= $designation['DepartmentId'] ?>', name: '<?= $designation['Name'] ?>'},
<?php endforeach; ?>
];

function setDesg() {
    let deptSelect = document.getElementById('dept-select');
    let desgSelect = document.getElementById('desg-select');
    desgSelect.value = '';
    desgSelect.innerHTML = '';
    for(let i=0; i<designations.length; i++) {
        if(designations[i].deptId == deptSelect.value) {
            desgSelect.innerHTML += `<option value="${designations[i].id}">${designations[i].name}</option>`
        }
    }
}

<?php if(isset($editUser['DesignationId'])): ?>
var editDesg = <?= $editUser['DesignationId'] ?>;
<?php else: ?>
var editDesg = -1;
<?php endif; ?>
function setEditDesg() {
    if(editDesg != -1) {
        let desgSelect = document.getElementById('desg-select');
        desgSelect.value = editDesg;
    }
}
</script>