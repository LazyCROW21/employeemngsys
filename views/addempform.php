<h2 class="ps-2">Add Staff</h2>
<hr>
<form class="border rounded p-2 border-light">
    <div class="divider">
        <div class="divider-text">Personal Details</div>
    </div>
    <div class="mb-3">
        <label for="name-input" class="col-form-label">Name</label>
        <input class="form-control" type="text" placeholder="Enter name here" id="name-input" />
    </div>
    <div class="mb-3">
        <label for="email-input" class="col-form-label">Email</label>
        <input class="form-control" type="email" placeholder="john@example.com" id="email-input" />
    </div>
    <div class="mb-3 row">
        <div class="col-12 col-md-6">
            <label for="phone-input" class="col-form-label">Phone</label>
            <input class="form-control" type="tel" placeholder="90-(164)-188-556" id="phone-input" />
        </div>
        <div class="col-12 col-md-6">
            <label for="alt-phone-input" class="col-md-2 col-form-label">Alt Phone</label>
            <input class="form-control" type="tel" placeholder="90-(164)-188-556" id="alt-phone-input" />
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-12 col-md-6">
            <label for="dob-input" class="col-form-label">Date Of Birth</label>
            <input class="form-control" type="date" value="2021-06-18" id="dob-input" />
        </div>
        <div class="col-12 col-md-6">
            <label class="col-form-label">Gender</label>
            <br />
            <div class="form-check form-check-inline">
                <input name="gender" class="form-check-input" type="radio" value="M" id="genderMale" />
                <label class="form-check-label" for="genderMale">
                    Male
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input name="gender" class="form-check-input" type="radio" value="F" id="genderFemale" />
                <label class="form-check-label" for="genderFemale">
                    Female
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input name="gender" class="form-check-input" type="radio" value="O" id="genderOther" />
                <label class="form-check-label" for="genderOther">
                    Other
                </label>
            </div>
        </div>

    </div>
    <div class="mb-3 row">
        <label class="col-12 col-form-label">Permanent Address</label>
        <div class="col-12 col-md-6 mb-3">
            <input class="form-control" type="text" placeholder="Address Line 1" />
        </div>
        <div class="col-12 col-md-6 mb-3">
            <input class="form-control" type="text" placeholder="Address Line 2" />
        </div>
        <div class="col-12 col-md-6">
            <input class="form-control" type="text" placeholder="City" />
        </div>
        <div class="col-12 col-md-6">
            <select class="select2 form-control" data-allow-clear="true">
                <option value="AK">Alaska</option>
                <option value="HI">Hawaii</option>
                <option value="CA">California</option>
                <option value="NV">Nevada</option>
                <option value="OR">Oregon</option>
                <option value="WA">Washington</option>
                <option value="AZ">Arizona</option>
                <option value="CO">Colorado</option>
                <option value="ID">Idaho</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NM">New Mexico</option>
                <option value="ND">North Dakota</option>
                <option value="UT">Utah</option>
                <option value="WY">Wyoming</option>
                <option value="AL">Alabama</option>
                <option value="AR">Arkansas</option>
                <option value="IL">Illinois</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="OK">Oklahoma</option>
                <option value="SD">South Dakota</option>
                <option value="TX">Texas</option>
                <option value="TN">Tennessee</option>
                <option value="WI">Wisconsin</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="IN">Indiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="OH">Ohio</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WV">West Virginia</option>
            </select>
        </div>
    </div>
    <div class="divider">
        <div class="divider-text">Professional Details</div>
    </div>
    <div class="mb-3 row">
        <label class="col-12 col-form-label">Position</label>
        <div class="col-12 col-md-6 mb-3">
            <select class="select2 form-control" data-allow-clear="true">
                <option value="RI">Department 1</option>
                <option value="RI">Department 2</option>
                <option value="RI">Department 3</option>
                <option value="RI">Department 4</option>
            </select>
        </div>
        <div class="col-12 col-md-6">
            <select class="select2 form-control" data-allow-clear="true">
                <option value="RI">Desg 1</option>
                <option value="RI">Desg 2</option>
                <option value="RI">Desg 3</option>
                <option value="RI">Desg 4</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-12 col-md-6">
            <label for="salary-input" class="col-form-label">Cost to Company (in Rs.)</label>
            <input class="form-control" type="number" min="0" step="1" value="500000" id="salary-input" />
        </div>
        <div class="col-12 col-md-6">
            <label for="date-input" class="col-form-label">Date Of Joining</label>
            <input class="form-control" type="date" value="2021-06-18" id="date-input" />
        </div>
    </div>
    <div class="d-flex flex-row-reverse">
        <button type="button" class="btn rounded-pill me-2 btn-primary">Submit</button>
    </div>

</form>