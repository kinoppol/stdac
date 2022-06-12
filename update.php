<?php
$output = shell_exec('who am i');
print $output;
$output = shell_exec('sudo who am i');
print $output;
$output = shell_exec('sudo git pull');
print $output;