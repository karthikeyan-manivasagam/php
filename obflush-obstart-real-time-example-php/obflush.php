<?php
/*
ob_start();

echo "Hello";
echo "World";

$out2 = ob_get_contents();

//ob_end_clean();
ob_flush();
ob_end_flush();
*/

ini_set('display_errors', 1);
global $file, $output;

$filename = basename($_SERVER["SCRIPT_FILENAME"], '.php');
$file = $filename.'.html';

if(file_exists($file)) {
   $output = file_get_contents($file);
}else {
  generate_output();	
}




echo $output;




function generate_output() {
  global $file, $output;
  ob_start();

  echo "Realtime example of ob_flush, now Im going to cache this output in somefile <br/>";

  echo "This output will be generated only when the html file is not exist see the above condition at top <br/>";

  echo "it will check for HTML File which is exist with this current filename if the HMTL is not exist then it will execute this function and generate html file<br/>";

  echo "This Beginning HTML file redirection can be handled in .htaccess also in a way that if html file is not exist then look for php file <br/>";

  $time = date('Y-m-d H:i:s');

  echo "Hello World ".$time;

  $output = ob_get_contents();

  ob_end_clean();
  ob_end_flush();

  $file_ob = fopen($file, 'w');
  fwrite($file_ob,$output);
  fclose($file_ob);
}
