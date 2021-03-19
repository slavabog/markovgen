<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Markov dorgen</title>
</head>
<body>
<?php
require 'markov.php';

$domain = ''; // domain of doorway
$site = 57; // doorway id

$id = count(scandir('/var/www/4erteg/data/www/'.$domain.'/db/'));
$id++;
$file1 = file_get_contents('/var/www/4erteg/data/www/4erteg/develop/parsing/db/'.$site.'.txt');
$keywords0 = preg_split("/[\r\n]+/", $file1);

while ($id < count($keywords0))
{
$explode_string = explode(";", $keywords0[$id]);


$file1 = file_get_contents('/var/www/4erteg/data/www/4erteg/develop/generator/texts/text'.$site.'.txt');


$order = 4; $length = rand(2500,3000); // length 2500-3000
        $markov_table = generate_markov_table($file1, $order);
        $markov = generate_markov_text($length, $markov_table, $order);

        if (get_magic_quotes_gpc()) $markov = stripslashes($markov);
$keys0 = $explode_string[2];
$text = $keys0.".".nl2br($markov).".".$keys0.".";
$category = rand(1,31);
$imgrand = rand(1,100);
$img = '<img src="img/'.$imgrand.'.jpg">';

$doorwayarray[0] = $id;
$doorwayarray[1] = $category;
$doorwayarray[2] = $keys0;
$doorwayarray[3] = $img;
$doorwayarray[4] = $text;

$string = $doorwayarray[0]."&;".$doorwayarray[1]."&;".$doorwayarray[2]."&;".$doorwayarray[3]."&;".$doorwayarray[4];

file_put_contents("/var/www/4erteg/data/www/".$domain."/db/".$id.".txt", $string, FILE_APPEND | LOCK_EX);


$categorystring = $id.";".$keys0."\r\n";

file_put_contents("/var/www/4erteg/data/www/".$domain."/categoriesdb/category".$category.".txt", $categorystring, FILE_APPEND | LOCK_EX);

$id++;   
}
?>
</body>
</html>