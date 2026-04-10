<?php

while(!feof($logs))
  {
  echo fgets($logs). "<br />";
  }
fclose($logs);
