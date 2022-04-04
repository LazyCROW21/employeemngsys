<h2 class="ps-2">Request a Leave</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-12 col-md-6 align-self-center">
        <form class="border rounded p-2 border-light">
            <div class="mb-3">
                <label for="name-input" class="col-form-label">Type of leave</label>
                <select class="select2 form-control" data-allow-clear="true">
                    <option value="AK">Restricted Holiday</option>
                    <option value="HI">Vacation</option>
                    <option value="HI">Sick - Self</option>
                    <option value="HI">Sick - Family</option>
                    <option value="HI">Civil Duty</option>
                    <option value="HI">Funeral</option>
                    <option value="HI">Maternity</option>
                    <option value="HI">Parental</option>
                    <option value="HI">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="name-input" class="col-form-label">Effect on Pay</label><br />
                <div class="form-check form-check-inline mt-3">
                    <input class="form-check-input" type="radio" name="effectonpay" id="inlineCheckbox1"
                        value="option1" />
                    <label class="form-check-label" for="inlineCheckbox1">Loss of Pay</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="effectonpay" id="inlineCheckbox2"
                        value="option2" />
                    <label class="form-check-label" for="inlineCheckbox2">With Pay</label>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="subject-input" class="col-12 col-form-label">From</label>
                <div class="col-12 col-md-6">
                    <select class="form-select" data-allow-clear="true">
                        <option value="AK">Morning</option>
                        <option value="HI">Evening</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <input class="form-control" type="date" value="2021-06-18" id="date-input" />
                </div>
            </div>
            <div class="mb-3 row">
                <label for="subject-input" class="col-12 col-form-label">To</label>
                <div class="col-12 col-md-6">
                    <select class="form-select" data-allow-clear="true">
                        <option value="AK">Morning</option>
                        <option value="HI">Evening</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <input class="form-control" type="date" value="2021-06-18" id="date-input" />
                </div>
            </div>
            <div class="mb-3">
                <label for="reason-input" class="col-form-label">Reason</label>
                <textarea class="form-control" type="text" placeholder="Enter subject here"
                    id="reason-input"></textarea>
            </div>
            <div class="d-flex flex-row-reverse">
                <button type="button" class="btn rounded-pill me-2 btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>