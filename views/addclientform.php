<?php
require_once "../models/clients.php";
require_once "../config/dbconfig.php";
$clientAdded = false;
if (isset($_POST['submitClient'])) {
    if(
        !isset($_POST['Name']) || !isset($_POST['Email']) ||
        !isset($_POST['Phone']) || !isset($_POST['Address']) ||
        !isset($_POST['City']) || !isset($_POST['State']) || !isset($_POST['Country'])
    ) {
        exit("invalid input");
    }
    $clientModel = new ClientModel($conn);
    $clientModel->insert($_POST);
    $clientAdded = true;
}
?>
<h2 class="ps-2">Add Client</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-12 col-md-8 align-self-center">
        <?php if($clientAdded): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            Client added succesfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        <form class="border rounded p-2 border-light" method="POST">
            <div class="mb-3">
                <label for="name-input" class="col-form-label">Name</label>
                <input name="Name" class="form-control" type="text" maxlength="200" placeholder="Enter name here"
                    id="name-input" required />
            </div>
            <div class="mb-3 row">
                <div class="col-12 col-md-6">
                    <label for="email-input" class="col-form-label">Email</label>
                    <input name="Email" class="form-control" type="email" placeholder="example@mail.com"
                        id="email-input" required />
                </div>
                <div class="col-12 col-md-6">
                    <label for="phone-input" class="col-form-label">Phone</label>
                    <input name="Phone" class="form-control" type="text" maxlength="10" pattern="[0-9]{10}"
                        placeholder="Enter phone here" id="phone-input" required />
                </div>
            </div>
            <div class="mb-3">
                <label for="addr-input" class="col-form-label">Address</label>
                <textarea name="Address" class="form-control" maxlength="210" placeholder="Enter address here"
                    id="addr-input" required></textarea>
            </div>
            <div class="mb-3 row">
                <div class="col-12 col-md-4">
                    <label for="city-input" class="col-form-label">City</label>
                    <input name="City" class="form-control" type="text" maxlength="50"
                        placeholder="Enter city name here" id="city-input" required />
                </div>
                <div class="col-12 col-md-4">
                    <label for="state-input" class="col-form-label">State</label>
                    <input name="State" class="form-control" type="text" maxlength="50"
                        placeholder="Enter state here" id="state-input" required />
                </div>
                <div class="col-12 col-md-4">
                    <label for="country-input" class="col-form-label">Country</label>
                    <input name="Country" class="form-control" type="text" maxlength="50"
                        placeholder="Enter country here" id="country-input" required />
                </div>
            </div>
            <div class="d-flex flex-row-reverse">
                <button type="submit" name="submitClient" class="btn rounded-pill me-2 btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>