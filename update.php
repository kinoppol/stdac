<?php
$output = shell_exec('who am i');
$output = shell_exec('sudo who am i');
$output = shell_exec('sudo git pull');
print $output;