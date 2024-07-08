<?php
$_server = "localhost"; 
$_user = "root";
$_passward = "";
$_db = "college";

$con = mysqli_connect($_server, $_user, $_passward, $_db);

if($con){
    ?>
        <script>
            alert("connection success");
        </script>

    <?php
}else {
    ?>
        <script>
            alert("connection failed");
        </script>

    <?php
}
?>