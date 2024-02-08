<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Document</title>
    <style type="text/css">
        img {
            transition: fransform 0.25s ease;
        }

        img:hover {
            -webkit-transform: scale(1.5);
            transform: scale(1.5);
        }
    </style>0
</head>
<body>
    
    <?php
    
    require "connect.php";

    $sql_select = "SELECT * FROM food, menu";
    $stmt_s = $conn->prepare($sql_select);
    $stmt_s->execute();

    if (isset($_POST["submit"])) {
        if (!empty($_POST['FoodName'])) {

            $uploadFile = $_FILES["FoodImage"]["name"];
            $tmpFile = $_FILES["FoodImage"]["tmp_name"];
            echo " upload file = " . $uploadFile;
            echo " tmp file = " . $tmpFile;

            $sql = "insert into food (FoodName, FoodPrice, FoodImage, MenuId) values
            (:FoodName, :FoodPrice, :FoodImage, :MenuId)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":FoodName", $_POST["FoodName"]);
            $stmt->bindParam(":FoodPrice", $_POST["FoodPrice"]);
            $stmt->bindParam(":FoodImage", $uploadFile);
            $stmt->bindParam(":MenuId", $_POST["MenuId"]);
            echo "image = " . $uploadFile;

            $fullpath = "./image/" . $uploadFile;
            echo " fullpath = " . $fullpath;
            move_uploaded_file($tmpFile, $fullpath);

            echo '
            <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
            ';

            try {
                if ($stmt->execute()) :
                    echo '
                    <script type="text/javascript">        
                        $(document).ready(function(){
                    
                            swal({
                                title: "Success!",
                                text: "Successfuly add customer",
                                type: "success",
                                timer: 2500,
                                showConfirmButton: false
                            }, function(){
                                    window.location.href = "index.php";
                            });
                        });                    
                        </script>
                    ';
                else :
                    $message = "Fail to add new Food";
                endif;
            }catch (PDOException $e) {
                echo "Fail!" . $e;
            }
            $conn = null;
        }
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3>Form add Food</h3>
                <form action="addFood.php" method="POST" enctype="multipart/form-data">
                    <input type="text" placeholder="FoodName" name="FoodName" required>
                    <br><br>
                    <input type="number" placeholder="FoodPrice" name="FoodPrice" required>
                    <br><br>
                    <div>แนบรูป</div>
                    <input type="file" placeholder="FoodImage" name="FoodImage" required>
                    <br><br>
                    <label>Select a Country Code</label>
                    <select name="MenuId">
                        <?php
                            while ($drop = $stmt_s->fetch(PDO::FETCH_ASSOC)) :
                        ?>
                        <option value="<?php echo $drop["MenuId"]; ?>">
                                <?php echo $drop["MenuName"]; ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                    <br><br>
                    <input type="submit" value="Submit" name="submit">
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#customerTable').DataTable();
        });
    </script>


</body>
</html>