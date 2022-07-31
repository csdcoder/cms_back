<?php
function echoj($var) {
  echo json_encode($var);
}

function require_file($file, $msg="Method is not exist.") {
  if(file_exists($file)) {
    require $file;
  } else {
    echo $msg;
    die;
  }
}