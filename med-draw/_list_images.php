<?php
    $images = glob('./images/*.png');
    $masks = glob('./upload/mask/*.png');
    // echo $images[0];
    echo '<select id="imglist" class="custom-select" size="10" onchange="readImage()" style="text-align: center">';
    for ($i=0; $i < count($images); $i++) { 
        $fn = explode('/', $images[$i]);
        $fn = end($fn);
        $a = substr($fn, 0, -4);
        $clr = 'black';
        for ($j=0; $j < count($masks); $j++)
        {
            $mfn = explode('/', $masks[$j]);
            $mfn = end($mfn);
            $b = substr($mfn, 0, -9);
            
            if ($a == $b)
            {
                echo 'a:'.$a.'---b:'.$b.'++++';
                $clr = 'red';
                break;
            }
        }
        echo '<option value=http://vision.cs.stonybrook.edu/~lehhou/tcga/medraw0/images/'.$fn.' style="color:'.$clr.'">'.$fn.'</option>';
    }
    echo '</select>';
?> 
