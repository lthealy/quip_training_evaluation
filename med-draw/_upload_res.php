<?php
    $fn  = $_POST['fn'];
    $mask = $_POST['mask'];
    $jss = $_POST['jss'];
    // $file = fopen("./upload/".$fn."rec", "w");
    // echo fwrite($file, $jss);
    // fclose($file);
    // echo $mask;
    // echo $jss;

    // save mask
    $jss_dir = './upload/jss/';
    $mask_dir = './upload/mask/';
    $mask = str_replace('data:image/png;base64,', '', $mask);
    $mask = str_replace(' ', '+', $mask);
    $data = base64_decode($mask);
    $file = $mask_dir.$fn;
    file_put_contents($file, $data);
    chmod($file, 0755);

    // save jss
    $file = fopen($jss_dir.$fn.".json", "w");
    fwrite($file, $jss);
    fclose($file);
    file_put_contents($file, $data);
    chmod($jss_dir.$fn.".json", 0755);
?> 