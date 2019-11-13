<?php
function uploadImage($file_id,$target_dir) {
    if (isset ($_FILES[$file_id])){
        $imagename = $_FILES[$file_id][‘name’];
        $source = $_FILES[$file_id][‘tmp_name’];
        $type=$_FILES[$file_id][‘type’];
    
        if(($_FILES[$file_id][‘type’]==’image/jpeg’) ||
        ($_FILES[$file_id][‘type’]==’image/png’)||
        ($_FILES[$file_id][‘type’]==’image/bmp’)||
        ($_FILES[$file_id][‘type’]==’image/tiff’)||
        ($_FILES[$file_id][‘type’]==’image/gif’)){
            $target = $target_dir.$file_id.$type;
            move_uploaded_file($source, $target);
            
            $imagepath = $imagename;
            $save = “../upload/” . $imagepath; //This is the new file you saving
            $file = “../upload/” . $imagepath; //This is the original file
            
            list($width, $height) = getimagesize($file) ;
            
            $tn = imagecreatetruecolor($width, $height) ;
            $image = imagecreatefromjpeg($file) ;
            imagecopyresampled($tn, $image, 0, 0, 0, 0, $width, $height, $width, $height) ;
            
            imagejpeg($tn, $save, 75) ;
            
            $save = “../upload/sml_” . $thumbfile=$imagepath; //This is the new file you saving
            $file = “../upload/” . $fullimage=$imagepath; //This is the original file
            
            list($width, $height) = getimagesize($file) ;
            
            $modwidth = 155;
            
            $diff = $width / $modwidth;
            
            $modheight = 130;
            $tn = imagecreatetruecolor($modwidth, $modheight) ;
            $image = imagecreatefromjpeg($file) ;
            imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;
            
            imagejpeg($tn, $save, 100) ;
            “Large image: <img src=’images/”.$imagepath.”‘><br>”;
            “Thumbnail: <img src=’images/sml_”.$imagepath.”‘>”;
    
        }
    }
}
?>