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
</head>

<body>
    <div class="container py-3">
        <div class="border">
            <div class="text-uppercase">
                <h3 class="text-center">Employee Management System</h3>
                <h3 class="text-center">Meshana</h3>
                <h3 class="text-center">Pay Slip For the Month April 2022</h3>
            </div>
            <hr />
            <div class="text-uppercase">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>Name</td><td>ASD AS</td>
                            <td>Employee Id</td><td>123</td>
                        </tr>
                        <tr>
                            <td>Email</td><td>ASD AS</td>
                            <td>Phone</td><td>123123</td>
                        </tr>
                        <tr>
                            <td>Department</td><td>asdad</td>
                            <td>Designation</td><td>ASD AS</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr />
            <div class="text-uppercase">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>PAN</td><td>ASD AS</td>
                            <td>Bank Account NO.</td><td>123</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr />
            <div class="text-uppercase">
                <table class="table table-borderless">
                    <thead class="text-center">
                        <tr><td colspan="2">Earnings</td><td colspan="2">Deductions</td></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Basic</td><td class="text-end">12313</td>
                            <td class="border-start">Income Tax</td><td class="text-end">123</td>
                        </tr>
                        <tr>
                            <td>House Rent Allowance</td><td class="text-end">ASD AS</td>
                            <td class="border-start">Professional Tax</td><td class="text-end">123</td>
                        </tr>
                        <tr>
                            <td>Dearness Allowance</td><td class="text-end">ASD AS</td>
                            <td class="border-start">Provident Fund</td><td class="text-end">123</td>
                        </tr>
                        <tr>
                            <td>Travelling Allowance</td><td class="text-end">ASD AS</td>
                            <td class="border-start">Employees' State Insurance</td><td class="text-end">123</td>
                        </tr>
                        <tr>
                            <td>Medical Allowance</td><td class="text-end">ASD AS</td>
                            <td class="border-start"></td><td></td>
                        </tr>
                        <tr>
                            <td>Bonus</td><td class="text-end">ASD AS</td>
                            <td class="border-start"></td><td></td>
                        </tr>
                        <tr>
                            <td>Overtime</td><td class="text-end">ASD AS</td>
                            <td class="border-start"></td><td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr />
            <div class="text-uppercase">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>TOTAL EARNING</td><td class="text-end">ASD AS</td>
                        </tr>
                        <tr>
                            <td>TOTAL DEDUCTIONS</td><td class="text-end">ASD AS</td>
                        </tr>
                        <tr>
                            <td>NET PAY</td><td class="text-end">ASD AS</td>
                        </tr>
                    </tbody>
                </table>
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

</html>