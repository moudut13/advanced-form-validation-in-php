<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Au Register Forms by Colorlib</title>

    <!-- Icons font CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/main.css" rel="stylesheet" media="all">
</head>

<body>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $data = "form";

    // Create connection
    $conn = new mysqli($servername, $username, $password,$data);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //echo "Connected successfully";

    if (isset($_POST['submit'])){

        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $phone= $_POST['phone'];
        $image = $_FILES['image'];


        $image_name = $_FILES['image']['name'];
        $image_type = $_FILES['image']['type'];
        $image_tname = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $error_img = $_FILES['image']['error'];


        /*
         *
         */
        if (empty($name) && empty($birthday) && empty($gender) && empty($email) && empty($phone) && empty($image_name)){
            $error_all = "<p class=\" alert alert-danger \">* All fields are required<button class=\"close\" data-dismiss=\"alert\">&times;</button></p>";
        }else{

            $birthday_s = explode('/',$birthday);
            (int)$birthday_a = end($birthday_s) ;

            //echo $birthday;
            $condition = 2021;
            (int)$new_birthday = $condition - $birthday_a;
            //echo $new_birthday;
            if ($new_birthday >= 9 || $new_birthday <= 60){
                if (empty($gender)){
                    $error = "<p class=\" alert alert-danger \">Please! Select your gender<button class=\"close\" data-dismiss=\"alert\">&times;</button></p>";
                }else{
                    $new_email= explode('@',$email);
                    $s_email = end($new_email);
                    if ($s_email == "gmail.com" || $s_email == "yahoo.com" || $s_email == "diu.edu.bd"){
                        $num = ['017','013','019','014','015','016','018'];
                        $v_cell = substr($phone,0,3);
                        if (in_array($v_cell, $num)==true){
                            if (empty($image_name)){
                                $error = "<p class=\" alert alert-danger \">Please! Select your Image<button class=\"close\" data-dismiss=\"alert\">&times;</button></p>";
                            }else{
                                $new_img = explode('.',$image_name);
                                $s_img = end($new_img);
                                if ($s_img == "jpg" || $s_img== "png"){
                                    $ran = rand(1,99999);
                                    $s_name = md5($ran.time());
                                    $s_name_new = $s_name.".".$s_img;
                                    if (empty($error_img) == true){
                                        $sql = "INSERT INTO students_info (Name,Birthday,Gender,Email,Phone,image) VALUES ('$name','$birthday','$gender','$email','$phone','$s_name_new')";
                                        if ($conn->query($sql) === TRUE) {
                                            //echo "New record created successfully";
                                            move_uploaded_file($image_tname,"images/img/".$s_name_new);
                                            $error_all= "<p class=\" alert alert-success \">Data Save Success<button class=\"close\" data-dismiss=\"alert\">&times;</button></p>";
                                        } else {
                                            echo "Error: " . $sql . "<br>" . $conn->error;
                                        }

                                        $conn->close();
                                    }

                                }

                            }
                        }else{
                            $error = "<p class=\" alert alert-danger \">! Invalid your mobile number<button class=\"close\" data-dismiss=\"alert\">&times;</button></p>";
                        }

                    }else {
                        $error = "<p class=\" alert alert-danger \">Invalid your email!<button class=\"close\" data-dismiss=\"alert\">&times;</button></p>";
                    }
                }
            }else{
                $error = "<p class=\" alert alert-danger \">You must be 18 year old!<button class=\"close\" data-dismiss=\"alert\">&times;</button></p>";
            }
        }


        /*
         *
         */
        if(empty($name)){
            $error_name= "* Name fields is required";
        }
        if(empty($birthday)){
            $error_birthday= "* Birthday fields is required";
        }
        if(empty($gender)){
            $error_gender= "* Gender Number fields is required";
        }
        if(empty($email)){
            $error_email= "* Email fields is required";
        }
        if(empty($phone)){
            $error_phone = "* Phone Number fields is required";
        }
        if(empty($image_name)){
            $error_imgs = "* Image fields is required";
        }

    }


    ?>
    <div class="page-wrapper bg-gra-01 p-t-180 p-b-100 font-poppins">
        <div class="wrapper wrapper--w780">
            <div class="card card-3">
                <div class="card-heading">
                </div>
                <div class="card-body">
                    <a href="index.php" class="btn btn-primary">View All Students</a>
                    <br>
                    <br>
                    <h2 class="title">Registration Info</h2>
                    <span><?php if (isset($error)){echo $error;}if (isset($error_all)){echo $error_all;}?></span>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="input-group">
                            <input class="input--style-3" type="text" placeholder="Name" name="name">
                            <span style="color: red"><?php if(isset($error_name)){echo $error_name;}?></span>
                        </div>
                        <div class="input-group">
                            <input class="input--style-3 js-datepicker" type="text" placeholder="Birthdate" name="birthday">
                            <i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>
                            <span style="color: red"><?php if(isset($error_birthday)){echo $error_birthday;}?></span>
                        </div>
                        <div class="input-group">
                            <div class="rs-select2 js-select-simple select--no-search">
                                <span style="color: red"><?php if(isset($error_gender)){echo $error_gender;}?></span>
                                <select name="gender">
                                    <option value="">Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                                <div class="select-dropdown"></div>
                            </div>
                        </div>
                        <div class="input-group">
                            <input class="input--style-3" type="email" placeholder="Email" name="email">
                            <span style="color: red"><?php if(isset($error_email)){echo $error_email;}?></span>
                        </div>
                        <div class="input-group">
                            <input class="input--style-3" type="text" placeholder="Phone" name="phone">
                            <span style="color: red"><?php if(isset($error_phone)){echo $error_phone;}?></span>
                        </div>
                        <div class="input-group">
                            <label for="image" style="cursor: pointer"><img data-toggle="tooltip" data-placement="left" title="Profile Photo" src="images/1.png" alt="" style="width: 40px;"></label>
                            <input name="image" class="input--style-3"; type="file" id="image" style="display: none;">
                            <span style="color: red"><?php if(isset($error_imgs)){echo $error_imgs;}?></span>
                        </div>
                        <div class="p-t-10">
                            <button class="btn btn--pill btn--green" type="submit" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $('input[name="image"]').change(function (e){
            let file_url = URL.createObjectURL(e.target.files[0]);
            $('img#view_photo').attr('src',file_url);
        });

    </script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->