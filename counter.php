<?php

define("COUNTER_START_VALUE", 0);
define("COUNTER_LOG", "counter.log");

/*************************************************************************************************/
function IncrementCounter() 
{   
   $create_file = !file_exists(COUNTER_LOG);
   if( !($fh = fopen(COUNTER_LOG, $create_file ? "x+b" : "r+b")) )
      return "Error";       

   //Reading current value of counter:
   if($create_file)
      $count = COUNTER_START_VALUE;
   else
   {
      $count = (int)fread($fh, 9); //reads 9 digits (supposing max 1 billion count)   
      rewind($fh);
   }

   //Writing new counter value:
   if(!fwrite($fh, ++$count))
      return "Error";
   if(!fclose($fh))
      return "Error";       

   return str_pad($count,  STR_PAD_LEFT);
}

?>
