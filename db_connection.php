<?php

$db=mysqli_connect("localhost","root","","library");

if(!$db)
{

	die("failed to connect!" . mysqli_connect_error());
}

echo "Connected ";