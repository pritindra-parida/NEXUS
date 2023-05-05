<?php
  session_start();
  include('partials/_dbconnect.php');
  include('partials/_functions.php');

  $errorMessage = '&nbsp;';
  if (isset($_POST['username']) && isset($_POST['password'])) {
    $result = doLogin();
  if ($result != '') {
    $errorMessage = $result;
  }
}
?>