<?php

if (isset($_POST['submit'])){
    
    $newFileName = $_POST['filename'];
    if (empty($_POST['filename'])){
        $newFileName = "gallery";
    } else {
        $newFileName = strtolower(str_replace(" ", "-", $newFileName));
    }

    $imageTitle = $_POST['filetitle'];
    $imageDesc = $_POST['filedesc'];
    $imageAsk = $_POST['fileAsk'];
    
    $expireTime = $_POST['expire'];

    $buttonA = $_POST['button_a'];
    $buttonB = $_POST['button_b'];

    $file = $_FILES['file'];
    // print_r($file);

    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileTempName = $file['tmp_name'];
    $fileError = $file['error'];
    $fileSize = $file['size'];

    $fileExt = explode(".", $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array("jpg", "jpeg", "png");
    // BUG: there's still problem uploading JPEG file!

    if (in_array($fileActualExt, $allowed)){
        if ($fileError == 0){
            // 20000000b = 20000kb = 20mb
            if ($fileSize < 20000000){
                $imageFullName = $newFileName . "." . uniqid("", false) . "." . $fileActualExt;
                $fileDestination = "../gallery/" . $imageFullName;

                include_once "dbh.inc.php";

                if (empty($imageTitle) || empty($imageDesc) || empty($imageAsk) ||empty($expireTime)){
                    header("location: ../index.php?upload=empty");
                    exit();
                } else {
                    $sql = "SELECT * FROM games;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)){
                        echo "SQL statement failed!";
                    } else {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $rowCount = mysqli_num_rows($result);
                        $setImageOrder = $rowCount + 1;

                        $sql = "INSERT INTO games (buttonA, buttonB, expire, gameTitle, gameDesc, gameAsk, imgFullName, gameOrder) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                        if (!mysqli_stmt_prepare($stmt, $sql)){
                            echo "SQL statement failed!";
                        } else {
                            mysqli_stmt_bind_param($stmt, "sssssssi", $buttonA, $buttonB, $expireTime, $imageTitle, $imageDesc, $imageAsk, $imageFullName, $setImageOrder);
                            mysqli_stmt_execute($stmt);

                            move_uploaded_file($fileTempName, $fileDestination);
                            
                            header("location: ../index.php?upload=success");
                            exit();
                        }
                    }
                }

            } else {
                echo "File size is too big!";
                exit();
            }
        } else {
            echo "You had an error!";
            exit();
        }
    } else {
        echo "You need to upload a proper file type!";
        exit();
    }
}
elseif (isset($_POST['cms'])){
    header("location: ../cms.php");
    exit();
}
else {
    header("location: ../index.php");
    exit();
}