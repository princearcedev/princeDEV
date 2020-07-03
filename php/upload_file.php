<?php
    include "conn.php";
    $allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma");
    $extension = pathinfo($_FILES['icon_file']['name'], PATHINFO_EXTENSION);
    if ((($_FILES["icon_file"]["type"] == "video/mp4")
        || ($_FILES["icon_file"]["type"] == "audio/mp3")
        || ($_FILES["icon_file"]["type"] == "audio/wma")
        || ($_FILES["icon_file"]["type"] == "image/pjpeg")
        || ($_FILES["icon_file"]["type"] == "image/gif")
        || ($_FILES["icon_file"]["type"] == "image/jpeg"))
        && ($_FILES["icon_file"]["size"] < 200000000)
        && in_array($extension, $allowedExts))
        {
        if ($_FILES["icon_file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["icon_file"]["error"] . "<br />";
    }
    else{
        echo "Upload: " . $_FILES["icon_file"]["name"] . "<br />";
        echo "Type: " . $_FILES["icon_file"]["type"] . "<br />";
        echo "Size: " . ($_FILES["icon_file"]["size"] / 1024) . " Kb<br />";
        echo "Temp file: " . $_FILES["icon_file"]["tmp_name"] . "<br />";
    
        move_uploaded_file($_FILES["icon_file"]["tmp_name"],"../Videos/" . $_FILES["vid"]["name"]);
        $path_name = $_FILES["icon_file"]["name"];
        $date_updated = date("Y-m-d H:i:s");
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet);
        for ($i=0; $i < 10; $i++) {
            $token .= $codeAlphabet[random_int(0, $max-1)];
        }
        $video_id = 'VD-'.$token;
        $sql = "INSERT INTO videos (activity_id, video_id, video, date_updated) VALUES ('$activity_id','$video_id','$path_name','$date_updated')";
        if($conn_sql->query($sql) === TRUE){
        }else{
            echo "Error: " . $sql . "<br>" . $conn_sql->error;
        }  

        //echo "Stored in: " . "../Videos/" . $_FILES["vid"]["name"];
        }
  }
else
  {
  echo "Invalid file";
  }

?>