<?php
session_start();
include 'components/connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
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
    <title>HarvestCrops - Notice Creation Page</title>
</head>
<body class="notice_bg">
    <section class="mt-5 pt-5">
        <form class="rounded" action="components/notice_creation.php" method="post">
            <div class="container">
                <div class="section bg-cfe1b9 mb-4 shadow-lg rounded">
                    <div class="row p-5 m-4 d-flex align-items-center">
                        <a href="javascript:history.back();" class="text-decoration-none c-397F35  mb-4"><i class="fa-solid fa-backward"></i> back</a>
                        <h1 class="h3 mb-3 d-flex justify-content-center c-2E4F21">Notice Set-up</h1>
                        <div class="col-md-1"></div>
                        <div class="col"><div class="bg-1E5915 p-1 rounded mb-4 me-3"></div></div>
                        <div class="col-md-1"></div>
                        <label class="p-3 fw-bold">Notice Information</label>
                        <div class="col-md-6 mb-4">
                            <input type="text" name="notice_title" class="form-control mb-2"
                                placeholder="Title" required autofocus>
                        </div>
                        <div class="col-md-6 mb-4">
                            <input type="datetime-local" name="notice_schedule" class="form-control mb-2"
                                placeholder="Time" required autofocus>
                        </div>
                        <div class="col-md-12 mb-4">
                            <textarea type="text" name="notice_content" class="form-control mb-2"
                                placeholder="Content" required autofocus></textarea>
                        </div>
                        <hr>
                        <div class="col-md-12 d-flex justify-content-end align-items-center pt-4">
                            <button class="btn btn-lg bg-1e5915 c-e9ffff rounded button-ds" type="submit"
                                name="create">Create Notice</button>
                        </div>

                    </div>
                </div>
            </div>
        </form> 
    </section>
</body>

</html>