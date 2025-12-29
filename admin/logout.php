<?php

session_abort();
session_unset();

header("Location: login.php");

?>