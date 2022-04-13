<?php require_once '../config/checksession.php'; ?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>View Pay Slip - <?= isset($_GET['Id']) ? $_GET['Id'] : 'Error' ?></title>

    <meta name="description" content="Employee management system" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>
    <style>
        .font-sm {
            font-size: 0.8rem;
        }
    </style>
</head>

<body>
    <?php
        require_once '../models/payrolls.php';
        require_once '../config/dbconfig.php';
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
        $payModel = new PRModel($conn);
        $details = $payModel->findById(isset($_GET['Id']) ? $_GET['Id'] : -1);
        $UserId = ' - ';
        $UserName = ' - ';
        $Email = ' - ';
        $Phone = ' - ';
        $Department = ' - ';
        $Designation = ' - ';
        $PAN = ' - ';
        $BAN = ' - ';
        $Basic = ' - ';
        $HRA = ' - ';
        $DA = ' - ';
        $TA = ' - ';
        $IncomeTax = ' - ';
        $ProfessionalTax = ' - ';
        $PF = ' - ';
        $Overtime = ' - ';
        $Bonus = ' - ';
        $MA = ' - ';
        $ESI = ' - ';
        $Month = ' - ';
        $Year = ' - ';
        $GrantedBy = ' - ';

        $TotalE = ' - ';
        $TotalD = ' - ';
        $NetPay = ' - ';
        if($details) {
            $UserId = $details['UserId'];
            $UserName = $details['UserName'];
            $Email = $details['Email'];
            $Phone = $details['Phone'];
            $Department = $details['Department'];
            $Designation = $details['Designation'];
            $PAN = $details['PAN'];
            $BAN = $details['BAN'];
            $Basic = $details['Basic'];
            $HRA = $details['HRA'];
            $DA = $details['DA'];
            $TA = $details['TA'];
            $IncomeTax = $details['IncomeTax'];
            $ProfessionalTax = $details['ProfessionalTax'];
            $PF = $details['PF'];
            $Overtime = $details['Overtime'];
            $Bonus = $details['Bonus'];
            $MA = $details['MA'];
            $ESI = $details['ESI'];
            $Month = $months[$details['Month']];
            $Year = $details['Year'];
            $GrantedBy = $details['GrantedBy'];

            $TotalE = $Basic + $HRA + $DA + $TA + $MA + $Bonus + $Overtime;
            $TotalD = $IncomeTax + $ProfessionalTax + $PF + $ESI;
            $NetPay = $TotalE - $TotalD;
        }
    ?>
    <div class="container py-3 font-monospace">
        <div class="d-flex flex-row-reverse my-2">
            <button onclick="printSlip()" name="submitPayroll" value="submit"
                class="btn rounded-pill me-2 btn-primary">Print</button>
        </div>
        <div id="paper">
            <div class="border">
                <div class="text-uppercase border-bottom">
                    <h3 class="text-center">Employee Management System</h3>
                    <h3 class="text-center">Meshana</h3>
                    <h3 class="text-center">Pay Slip For the Month <?= $Month ?> <?= $Year ?></h3>
                </div>
                <div class="text-uppercase border-bottom font-sm">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Name</td>
                                <td><?= $UserName ?></td>
                                <td class="fw-bold">Employee Id</td>
                                <td><?= $UserId ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email</td>
                                <td><?= $Email ?></td>
                                <td class="fw-bold">Phone</td>
                                <td><?= $Phone ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Department</td>
                                <td><?= $Department ?></td>
                                <td class="fw-bold">Designation</td>
                                <td><?= $Designation ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-uppercase border-bottom font-sm">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="fw-bold">PAN</td>
                                <td><?= $PAN ?></td>
                                <td class="fw-bold">Bank Account NO.</td>
                                <td><?= $BAN ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-uppercase font-sm">
                    <table class="table table-borderless">
                        <thead class="text-center">
                            <tr>
                                <td colspan="2" class="fw-bold">Earnings</td>
                                <td colspan="2" class="fw-bold border-start">Deductions</td>
                            </tr>
                        </thead>
                        <tbody class="border-bottom">
                            <tr>
                                <td class="fw-bold">Basic</td>
                                <td class="text-end"><?= $Basic ?></td>
                                <td class="border-start fw-bold">Income Tax</td>
                                <td class="text-end"><?= $IncomeTax ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">House Rent Allowance</td>
                                <td class="text-end"><?= $HRA ?></td>
                                <td class="border-start fw-bold">Professional Tax</td>
                                <td class="text-end"><?= $ProfessionalTax ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Dearness Allowance</td>
                                <td class="text-end"><?= $DA ?></td>
                                <td class="border-start fw-bold">Provident Fund</td>
                                <td class="text-end"><?= $PF ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Travelling Allowance</td>
                                <td class="text-end"><?= $TA ?></td>
                                <td class="border-start fw-bold">Employees' State Insurance</td>
                                <td class="text-end"><?= $ESI ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Medical Allowance</td>
                                <td class="text-end"><?= $MA ?></td>
                                <td class="border-start"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Bonus</td>
                                <td class="text-end"><?= $Bonus ?></td>
                                <td class="border-start"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Overtime</td>
                                <td class="text-end"><?= $Overtime ?></td>
                                <td class="border-start"></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-uppercase font-sm">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="fw-bold">TOTAL EARNING</td>
                                <td class="text-end"><?= $TotalE ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">TOTAL DEDUCTIONS</td>
                                <td class="text-end"><?= $TotalD ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">NET PAY</td>
                                <td class="text-end"><?= $NetPay ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/libs/popper/popper.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
        function printSlip() {
            var originalBody = document.body.innerHTML;
            var printContent = document.getElementById('paper').innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalBody;
        }
    </script>

</html>