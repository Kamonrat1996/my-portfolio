<?php

require_once('customer_function.php');
$id = $_GET['id'];
deletecustomer($id);
    
?>

ลบข้อมูลเรียบร้อยแล้ว
</br>
<a href="show_all.php">back</a>