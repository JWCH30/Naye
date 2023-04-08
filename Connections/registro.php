<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_registro = "localhost";
$database_registro = "usuarios";
$username_registro = "root";
$password_registro = "";
$registro = mysql_pconnect($hostname_registro, $username_registro, $password_registro) or trigger_error(mysql_error(),E_USER_ERROR); 
?>