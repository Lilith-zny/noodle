<?php

if (isset($_POST['FoodId']) && isset($_POST['FoodName']) && isset($_POST['FoodPrice'])) {
    require 'connect.php';

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $FoodId = $_POST['FoodId'];
    $FoodName = $_POST['FoodName'];
    $FoodPrice =  $_POST['FoodPrice'];

    echo 'FoodId = ' . $FoodId;
    echo 'FoodName = ' . $FoodName;
    echo 'FoodPrice = ' . $FoodPrice;


    $sql = "UPDATE food SET FoodName = :FoodName, FoodPrice = :FoodPrice WHERE FoodId = :FoodId";
    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':FoodName', $_POST['FoodName']);
    $stmt->bindParam(':FoodPrice', $_POST['FoodPrice']);
    $stmt->bindParam(':FoodId', $_POST['FoodId']);


    echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

    if ($stmt->execute()) {
        echo '
        <script type="text/javascript">
        
        $(document).ready(function(){
        
            swal({
                title: "Success!",
                text: "Successfuly update customer information",
                type: "success",
                timer: 2500,
                showConfirmButton: false
              }, function(){
                    window.location.href = "index.php";
              });
        });
        
        </script>
        ';
    }
    $conn = null;
}
