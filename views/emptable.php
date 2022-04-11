<?php
  require_once "../models/users.php";
  require_once "../config/dbconfig.php";

  $userModel = new UserModel($conn);

  $rows = $userModel->findAll();
?>
<h2 class="ps-2">All Staff</h2>
<hr>
<div class="pt-0" style="overflow-x: auto; overflow-y: visible;">
  <table class="table table-hover border-top text-center" id="emptable">
    <thead>
      <tr>
        <th>#</th>
        <th class="text-start">Name</th>
        <th>Designation (Dept)</th>
        <th>Phone</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $count = 1;
        $currentDate = Date('Y-m-d');
      ?>
      <?php foreach($rows as $row): ?>
      <tr id="ur-<?= $row['Id'] ?>" data-user="<?= htmlentities(json_encode($row)) ?>">
        <td><?= $count++ ?></td>
        <td class="text-start"><?= $row['Name'] ?></td>
        <td><?= $row['DesignationId'] ?>(<?= $row['DepartmentId'] ?>)</td>
        <td><?= $row['Phone'] ?></td>
        <td>
          <?php if($row['DeletedAt'] == null): ?>
          <span class="badge bg-label-primary me-1">Active</span>
          <?php else: ?>
          <span class="badge bg-label-secondary me-1">Terminated</span>
          <?php endif; ?>
        </td>
        <td>
          <div class="action-btn dropdown dropstart">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                class="bx bx-dots-vertical-rounded"></i></button>
            <div class="dropdown-menu">
              <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#uModal" onclick="setModal(<?= $row['Id'] ?>)"><i class="bx bx-detail me-2"></i>Details</button>
              <?php if($row['DeletedAt'] == null): ?>
              <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-2"></i>Edit</a>
              <button class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-2"></i>Delete</button>
              <?php endif; ?>
            </div>
          </div>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>

<!-- Modal -->
<?php
$details = [
  'Id',
  'Name',
  'Email',
  'Phone',
  'DateOfBirth',
  'Gender',
  'Address',
  'City',
  'State',
  'Basic',
  'DateOfJoining',
  'DepartmentId',
  'DesignationId',
  'DepartmentName',
  'DesignationName',
  'DeletedAt',
  'CreatedBy',
  'CreatedAt'
];
?>
<div class="modal fade" id="uModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span id="mTitle"></span>'s Permissions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tbody>
                        <?php foreach($details as $detail): ?>
                        <tr>
                            <td><?= $detail ?></td>
                            <td>
                              <span id="U-<?= $detail ?>"></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <a id="mEdit" type="button" class="btn btn-primary" href="#">Edit</a>
            </div>
        </div>
    </div>
</div>

<script>
  function setModal(id) {
    var row = document.getElementById('ur-'+id);
    var data = JSON.parse(row.getAttribute('data-user'));
    document.getElementById('mTitle').innerText = data['Name']+"'s Details";
    document.getElementById('mEdit').href = '/addStaff.php?edit='+id;
    console.log(data);
    let details = [
      'Id',
      'Name',
      'Email',
      'Phone',
      'DateOfBirth',
      'Gender',
      'Address',
      'City',
      'State',
      'Basic',
      'DateOfJoining',
      'DepartmentId',
      'DesignationId',
      'DepartmentName',
      'DesignationName',
      'DeletedAt',
      'CreatedBy',
      'CreatedAt'
    ]
    for(let i=0; i<details.length; i++) {
      document.getElementById('U-'+details[i]).innerText = data[details[i]];
    }
  }
</script>