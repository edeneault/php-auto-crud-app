<?php
/*** set the content type header ***/
/*** Without this header, it wont work ***/
header("Content-type: text/css");


$font_family = 'Arial, Helvetica, sans-serif';
$font_size = '1em';
$border = '1px solid';
?>

table {
margin: 0;
padding: 10px;
}

tr {
font-family: <?=$font_family?>;
font-size: <?=$font_size?>;
background: #FFF;
color: #666;
padding: 10px 10px 10px 10px;
border-collapse: separate;
border: <?=$border?> #000;
margin: 0 auto;
}

td {
font-family: <?=$font_family?>;
font-size: <?=$font_size?>;
border: <?=$border?> #DDD;
padding: 10px 10px 10px 10px;
margin: 0 auto;
}
