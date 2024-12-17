<?php
$dbcon = @mysqli_connect('localhost', 'dreiancheta', 'dreiancheta', 'membners_ancheta')
OR die('Could not connect to MySQL. Error in '.mysqli_connect_error());
mysqli_set_charset($dbcon, 'utf8');
