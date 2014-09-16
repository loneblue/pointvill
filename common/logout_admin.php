<?php
include "../common/common.php";

session_unregister("USER_INFO");
setCookie("USER_KEY","",-1);					
session_destroy();

go_url("../admin/index.html");
?>