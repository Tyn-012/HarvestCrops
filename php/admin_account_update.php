<?php
session_start();
include 'components/connect.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $_SESSION['user-id'] = $user_id;
} else {
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <script src="../css/bootstrap-5.3.3-dist/js/bootstrap.min.js" rel="script"></script>
    <title></title>
</head>
<body>
    <section>
        <form class="rounded" action="components/account_updates.php" method="post">
            <div class="container">
                <div class="section create-acc-form-ds mb-4">
                    <div class="row p-4 m-4 d-flex align-items-center">
                        <a href="javascript:history.back();" class="text-decoration-none text-dark"><i class="fa-solid fa-backward"></i> back</a>
                        <h1 class="h3 mb-3 d-flex justify-content-center mb-5">Update User Account</h1>
                        <div class="col-md-1"></div>
                        <div class="col-md-10"><hr class="rounded bg-dark p-1"></div>
                        <div class="col-md-1"></div>
                        <label class="p-3 fw-bold">Account Name</label>
                        <div class="col-md-4">
                            <input type="text" name="firstname" class="form-control mb-2"
                                placeholder="First Name" required autofocus>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="middlename" class="form-control mb-2"
                                placeholder="Middle Name" required autofocus>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="lastname" class="form-control mb-2"
                                placeholder="Last Name" required autofocus>
                        </div>
                        <div class="col-md-9">
                            <label class="pt-3 mb-2 fw-bold">Birth Date</label>
                        </div>
                        <div class="col-md-3">
                            <label class="pt-3 mb-2 fw-bold">Gender</label>
                        </div>
                        <div class="col-md-3">
                            <select name="birth-month" class="form-control" id="Month" required>
                                <option value="Month" disabled selected>Month</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="birth-day" class="form-control" id="Day" required>
                                <option value="Day" disabled selected>Day</option>
                                <option value="1">1</option><option value="2">2</option><option value="3">3</option>
                                <option value="4">4</option><option value="5">5</option><option value="6">6</option>
                                <option value="7">7</option><option value="8">8</option><option value="9">9</option>
                                <option value="10">10</option><option value="11">11</option><option value="12">12</option> 
                                <option value="13">13</option><option value="14">14</option><option value="15">15</option>
                                <option value="16">16</option><option value="17">17</option><option value="18">18</option> 
                                <option value="19">19</option><option value="20">20</option><option value="21">21</option>
                                <option value="22">22</option><option value="23">23</option><option value="24">24</option>
                                <option value="25">25</option><option value="26">26</option><option value="27">27</option>
                                <option value="28">28</option><option value="29">29</option><option value="30">30</option>
                                <option value="31">31</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="birth-year" class="form-control" id="Year" required>
                                <option value="Year" disabled selected>Year</option>
                                <option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option>
                                <option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option>
                                <option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option>
                                <option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option>
                                <option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option>
                                <option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option>
                                <option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option>
                                <option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option>
                                <option value="2024">2024</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <select name="userGender" class="form-control" id="Gender" required>
                                <option value="Gender" disabled selected>Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-12">
                            <label class="pt-5 mb-2 fw-bold">Account Information</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="EmailAdd" class="mt-3 form-control mb-2"
                            placeholder="Email Address" required autofocus>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="MobileNum" class="mt-3 form-control mb-2"
                            placeholder="Mobile Number" required autofocus>
                        </div>
                        <div class="col-md-4">
                            <input type="password" name="Password" class="mt-3 form-control mb-2"
                            placeholder="Password" required autofocus>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12 d-flex justify-content-end align-items-center pt-4">
                            <button class="btn btn-lg bg-secondary rounded" type="submit"
                                name="submit">Update
                                Account</button>
                        </div>
                            
                    </div>
                </div>
            </div>
        </form> 
    </section>
</body>
</html>