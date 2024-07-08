<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css" />

    <style>
        .scrollable-div {
            height: 70%; /* Set the desired height */
            width: 100%; /* Set the desired width */
            overflow: auto; /* Enable scrolling */
        }

        .horizontal-scroll{
            height: 90%; /* Set the desired height */
            width: 100%; /* Set the desired width */
            overflow: auto; /* Enable scrolling */
            white-space: nowrap;
        }

        .buttonNext {
            display: flex;
            width: 80%;
            height: 43px;
            background-color: #151111;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 0.8rem;
            font-size: 0.8rem;
            margin-bottom: 2rem;
            transition: 0.3s;
            text-decoration: none;
            place-items: center;
            justify-content: center;
        }

        .buttonNext:hover {
            background-color: #8371fd;
        }

    </style>

</head>
<body>
    <main>
        <div class="box">
          <div class="inner-box">
            <div class="forms-wrap">
                <div>
            <div class="logo" >
                        <img src="./img/logo.png" alt="easyclass" />
                        <h4>feedback system</h4>                         
                    </div><br>
            <h1>You have <br>successfully <br>completed the form.</h1>
            <br><h3>You may now proceed to exit.</h3>
            <br>
            <br>
            <a href="index.php" class="buttonNext">Exit</a> 
            </div>
                
            </div>
            <div class="carousel">
                <div class="images-wrapper">
                    <img src="./img/image1.png" class="image img-1 show" alt="" />
                    <img src="./img/image2.png" class="image img-2" alt="" />
                    <img src="./img/image3.png" class="image img-3" alt="" />
                    </div>
                
                    <div class="text-slider">
                        <div class="text-wrap">
                            <div class="text-group">
                                <h2>Create your own courses</h2>
                                <h2>Customize as you like</h2>
                                <h2>Invite students to your class</h2>
                            </div>
                        </div>
                        <div class="bullets">
                            <span class="active" data-value="1"></span>
                            <span data-value="2"></span>
                            <span data-value="3"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="app.js"></script>
</body>
</html>
