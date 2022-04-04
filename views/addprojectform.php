<h2 class="ps-2">Add Project</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-12 col-md-6 align-self-center">
        <form class="border rounded p-2 border-light">
            <div class="mb-3">
                <label for="proj-input" class="col-form-label">Project title</label>
                <input class="form-control" type="text" placeholder="Enter name here" id="proj-input" />
            </div>
            <div class="mb-3">
                <label for="desc-input" class="col-form-label">Project description</label>
                <textarea class="form-control" type="text" placeholder="Enter name here" id="desc-input"></textarea>
            </div>
            <div class="mb-3 row">
                <div class="col-12 col-md-6">
                    <label for="sdate-input" class="col-form-label">Starting date</label>
                    <input class="form-control" type="date" value="2021-06-18" id="sdate-input" />
                </div>
                <div class="col-12 col-md-6">
                    <label for="dline-input" class="col-form-label">Deadline</label>
                    <input class="form-control" type="date" value="2021-06-18" id="dline-input" />
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-12 col-md-6">
                    <label for="prio-input" class="col-form-label">Priority</label>
                    <select id="prio-input" class="form-select" data-allow-clear="true">
                        <option value="AK">High</option>
                        <option value="HI">Low</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label for="earn-input" class="col-form-label">Earning (in Rs.)</label>
                    <input class="form-control" type="number" min="0" value="15000" id="earn-input" />
                </div>
            </div>
            <div class="mb-3">
                <label for="name-input" class="col-form-label">Select Employee</label>
                <select class="select2 form-control" multiple>
                    <option value="AK">Alaska</option>
                    <option value="HI">Hawaii</option>
                </select>
            </div>
            <div class="d-flex flex-row-reverse">
                <button type="button" class="btn rounded-pill me-2 btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>