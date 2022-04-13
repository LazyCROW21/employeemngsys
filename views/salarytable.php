<?php
require_once "../models/payrolls.php";
require_once "../config/dbconfig.php";

$prModel = new PRModel($conn);
$months = [
    1 => 'January',
    2 => 'Febuary',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December'
];

function getPay($data) {
    $pay = 0;
    $pay += $data['Basic'];
    $pay += $data['HRA'];
    $pay += $data['DA'];
    $pay += $data['TA'];
    $pay += $data['Overtime'];
    $pay += $data['Bonus'];
    $pay += $data['MA'];
    $pay -= $data['IncomeTax'];
    $pay += $data['ProfessionalTax'];
    $pay += $data['PF'];
    $pay += $data['ESI'];
    return $pay;
}

$rows = $prModel->findByUserId($_SESSION['UserId']);
?>

<h2 class="ps-2">Payment History</h2>
<hr>
<!-- table-responsive -->
<div class="pt-0" style="overflow-x: auto; overflow-y: visible;">
    <table class="table table-hover border-top text-center" id="salarytable">
        <thead>
            <tr>
                <th>#</th>
                <th class="text-start">Employee</th>
                <th>Designation</th>
                <th>Department</th>
                <th class="text-end">Pay</th>
                <th>Month</th>
                <th>Year</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $currentDate = Date('Y-m-d');
            ?>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td class="text-start"><?= $row['UserName'] ?></td>
                    <td><?= $row['Designation'] ?></td>
                    <td><?= $row['Department'] ?></td>
                    <td class="text-end"><?= getPay($row) ?></td>
                    <td><?= $months[$row['Month']] ?></td>
                    <td><?= $row['Year'] ?></td>
                    <td>
                        <div class="action-btn dropdown dropstart">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" target="_blank" href="/viewPaySlip.php?Id=<?= $row['Id'] ?>"><i class="bx bx-printer me-2"></i>Print</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>