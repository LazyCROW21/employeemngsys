<h2 class="ps-2">Add Admin</h2>
<hr>
<div class="row justify-content-center">
    <div class="col-12 col-md-6 align-self-center">
        <form class="border rounded p-2 border-light">
            <div class="mb-3">
                <label for="name-input" class="col-form-label">Select Employee</label>
                <select class="select2 form-control" data-allow-clear="true">
                    <option value="AK">Alaska</option>
                    <option value="HI">Hawaii</option>
                </select>
            </div>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>Permission</th>
                        <th>VIEW</th>
                        <th>CREATE</th>
                        <th>MODIFY</th>
                        <th>DELETE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $modules = ['department', 'designation', 'employee', 'payroll', 'project', 'leave', 'client', 'admin'];
                    ?>
                    <?php foreach($modules as $module): ?>
                    <tr>
                        <td><?= $module ?></td>
                        <td>
                            <input class="form-check-input" type="checkbox" value="" />
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" value="" />
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" value="" />
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" value="" />
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex flex-row-reverse">
                <button type="button" class="btn rounded-pill me-2 btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>