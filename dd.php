<?php
require_once('simple_html_dom.php');
$quer=$_POST["query1"];
$count=$_POST["count"];
$option = $_POST["optradio"];
$j=10;


   $m=0;

$file = fopen("greu.csv","w");


for($i=1;$i<$count;$i++)
{
	if($option =="web"){
  echo "Page ".$i."<br>";
}

   

$url  = 'http://www.google.com/search?hl=en&safe=active&tbo=d&site=&source=hp&q='.$quer.'&start='.$j;
$html = file_get_html($url);
 $j=$j+10;
$linkObjs = $html->find('h3.r a');
foreach ($linkObjs as $linkObj) {
    $title = trim($linkObj->plaintext);
    $link  = trim($linkObj->href);
    
    // if it is not a direct link but url reference found inside it, then extract
    if (!preg_match('/^https?/', $link) && preg_match('/q=(.+)&amp;sa=/U', $link, $matches) && preg_match('/^https?/', $matches[1])) {
        $link = $matches[1];
    } else if (!preg_match('/^https?/', $link)) { // skip if it is not a valid link
        continue;    
    }
    
    $array1[$m]=$link;
    $m++;

    if($option == "web")
    {
    echo '<p>Title: ' . $title . '<br />';
    echo 'Link: ' . $link . '</p>';    
  }


}

}


if($option == "csv")
{

foreach ($array1 as $line)
  {
  fputcsv($file,explode(',',$line));
  }


  ?>
  <center>
  <h3>CSV Generated</h3>

<a href="file.php">Download</a>
</center>
  <?php

}

fclose($file); ?> 