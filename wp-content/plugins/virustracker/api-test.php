<?php
// Takes raw data from the request
$json = file_get_contents('php://input');

print_r( $json);