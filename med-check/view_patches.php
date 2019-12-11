<html>
<head>
<?php $y = $_COOKIE["y"];?>
<title>view_patches</title>
<style>
.page_container {
    width: 100%;
    margin: auto;
}
.instance_container {
    border: 2px solid #73AD21;
    padding: 2px;
    float: left;
}
.label_frame {
    float: left;
}
.img_frame {
    float: left;
}
</style>
</head>
<body>

<?php
print "<body onScroll=\"document.cookie='y=' + window.pageYOffset\" onLoad='window.scrollTo(0,$y)'>";
?>

<?PHP
$page = $_GET['page'];
$ctype = $_GET['ctype'];

$N_per_page = 6;
$folder = sprintf("patches_%s", $ctype);
?>

<a href=view_patches.php?ctype=<?PHP printf("%s", $ctype);?>&page=<?PHP printf("%d", max(0, $page - 1));?>>Prev Page</a>
<a href=view_patches.php?ctype=<?PHP printf("%s", $ctype);?>&page=<?PHP printf("%d", $page + 1);?>>Next Page</a>
<p>
<?PHP
$im_id = ($page + 2) * $N_per_page;
if (file_exists(sprintf('%s/%d.png', $folder, $im_id))) {
    printf('You are in tumor [<b>%s</b>], page [<b>%d</b>]', $ctype, $page);
} else {
    printf('You are in tumor [<b>%s</b>], page [<b>%d</b>]. <b>You have reached to the last page.</b>', $ctype, $page);
}
?>
<p>

<?PHP
printf("<section class=\"page_container\">\n\n");
for ($i = 1; $i <= $N_per_page; ++$i) {
    $im_id = $i + $page * $N_per_page;

    if (file_exists(sprintf('%s/%d.png', $folder, $im_id))) {
        $savef = sprintf("./label_files_%s/im_id_%d.txt", $ctype, $im_id);
        if ($myfile = fopen($savef, 'r'))
            $class = fread($myfile, 20);
        else
            $class = '';

        printf("<section class=\"instance_container\">\n");
 
        printf("<div class=\"label_frame\">\n");
        printf("<form name=\"label\" method=\"POST\" action=label.php?ctype=%s&page=%d&im_id=%d>\n", $ctype, $page, $im_id);
        printf("<input type=\"submit\" name=\"c1\" value=\"%s\"> Low <br>\n", strpos($class,'c1')!==false ? 'x':'  ');
        printf("<input type=\"submit\" name=\"c2\" value=\"%s\"> Medium <br>\n", strpos($class,'c2')!==false ? 'x':'  ');
        printf("<input type=\"submit\" name=\"c3\" value=\"%s\"> High <br>\n", strpos($class,'c3')!==false ? 'x':'  ');
        printf("<input type=\"submit\" name=\"c4\" value=\"%s\"> Ignore <br>\n", strpos($class,'c4')!==false ? 'x':'  ');
        printf("<br>\n");
        printf("<input type=\"submit\" name=\"cr\" value=\"  \"> Clear <br>\n");
        printf("</form>\n");
        printf("</div>\n");
 
        printf("<div class=\"img_frame\">\n");
        printf("<img height=400px src=\"%s/%d.png\"/>\n", $folder, $im_id);
        printf("</div>\n");
        printf("</section>\n\n");
    }
}
printf("</section>\n");
?>

</body>
</html>

