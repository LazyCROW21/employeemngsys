<?php
require_once "../models/clients.php";
require_once "../config/dbconfig.php";
$clientAdded = false;
$duplicate = false;
$error = false;
$editFlag = false;
$clientUpdate = false;
$editClient = array();

$clientModel = new ClientModel($conn);

if (isset($_POST['submitClient'])) {
    if(
        !isset($_POST['Name']) || !isset($_POST['Email']) ||
        !isset($_POST['Phone']) || !isset($_POST['Address']) ||
        !isset($_POST['City']) || !isset($_POST['State']) || !isset($_POST['Country'])
    ) {
        $error = true;
    } else {
        if(isset($_GET['edit'])) {
            $_POST['Id'] = $_GET['edit'];
            $result = $clientModel->update($_POST);
            if($result == 'success'){
                $clientUpdate = true;
            } 
            elseif($result == 'duplicate') {
                $duplicate = true;
            }
            else {
                $error = true;
            }
        }
        else {
            $result = $clientModel->insert($_POST);
            if($result == 'success'){
                $clientAdded = true;
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
    $editClient = $clientModel->findById($_GET['edit']);
}
?>
<?php if($editFlag): ?>
<h2 class="ps-2">Edit Client</h2>
<?php else: ?>
<h2 class="ps-2">Add Client</h2>
<?php endif; ?>
<hr>
<div class="row justify-content-center">
    <div class="col-12 col-md-8 align-self-center">
        <?php if($clientAdded): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            Client added succesfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($clientUpdate): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            Client updated succesfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($duplicate): ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            Client not added, duplicate entry!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($error && $editFlag): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            Client cannot be updated due to some error/invalid entry!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif($error && !$editFlag): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            Client cannot be added due to some error/invalid entry!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        <form class="border rounded p-2 border-light" method="POST">
            <div class="mb-3">
                <label for="name-input" class="col-form-label">Name</label>
                <input name="Name" class="form-control" type="text" maxlength="200" placeholder="Enter name here"
                    id="name-input" value="<?= isset($editClient['Name']) ? $editClient['Name'] : '' ?>" required />
            </div>
            <div class="mb-3 row">
                <div class="col-12 col-md-6">
                    <label for="email-input" class="col-form-label">Email</label>
                    <input name="Email" class="form-control" type="email" placeholder="example@mail.com"
                        id="email-input" value="<?= isset($editClient['Email']) ? $editClient['Email'] : '' ?>" required />
                </div>
                <div class="col-12 col-md-6">
                    <label for="phone-input" class="col-form-label">Phone</label>
                    <input name="Phone" class="form-control" type="text" maxlength="10" pattern="[0-9]{10}"
                        placeholder="Enter phone here" value="<?= isset($editClient['Phone']) ? $editClient['Phone'] : '' ?>" id="phone-input" required />
                </div>
            </div>
            <div class="mb-3">
                <label for="addr-input" class="col-form-label">Address</label>
                <textarea name="Address" class="form-control" maxlength="210" placeholder="Enter address here"
                    id="addr-input" required><?= isset($editClient['Address']) ? $editClient['Address'] : '' ?></textarea>
            </div>
            <div class="mb-3 row">
                <div class="col-12 col-md-4">
                    <label for="city-input" class="col-form-label">City</label>
                    <input name="City" class="form-control" type="text" maxlength="50" value="<?= isset($editClient['City']) ? $editClient['City'] : '' ?>"
                        placeholder="Enter city name here" id="city-input" required />
                </div>
                <div class="col-12 col-md-4">
                    <label for="state-input" class="col-form-label">State</label>
                    <input name="State" class="form-control" type="text" maxlength="50" value="<?= isset($editClient['State']) ? $editClient['State'] : '' ?>"
                        placeholder="Enter state here" id="state-input" required />
                </div>
                <div class="col-12 col-md-4">
                    <label for="country-input" class="col-form-label">Country</label>
                    <input name="Country" class="form-control" type="text" maxlength="50" value="<?= isset($editClient['Country']) ? $editClient['Country'] : '' ?>"
                        placeholder="Enter country here" id="country-input" required />
                </div>
            </div>
            <div class="d-flex flex-row-reverse">
                <button type="submit" name="submitClient" value="submit" class="btn rounded-pill me-2 btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>