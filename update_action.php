<?php

require_once("customer_function.php");
session_start();

$id       = $_POST['id'];
$name       = $_POST['name'];
$surname    = $_POST['surname'];
$phone      = $_POST['phone'];
$email      = $_POST['email'];
$submit    = $_POST['submit'];

// กำหนดอายุคุกกี้ (เช่น 1 วัน)
//$expiry_time = time() + (60 * 60 * 24);

// 1. สร้าง/อัปเดตคุกกี้ทันทีที่รับค่าจากฟอร์ม (เพื่อเก็บค่าเก่าไว้เผื่อเกิด Error)
//setcookie("id", $id, $expiry_time, "/");
//setcookie("name", $name, $expiry_time, "/");
//setcookie("surname", $surname, $expiry_time, "/");
//setcookie("phone", $phone, $expiry_time, "/");
//setcookie("email", $email, $expiry_time, "/");    


$_SESSION['name']    = $name;
$_SESSION['surname'] = $surname;
$_SESSION['phone']   = $phone;
$_SESSION['email']   = $email;

    if(!isset($submit))
    {
        header("location:insert_form.php"); //หากผู้ใช้ไม่ได้กดปุ่ม Submit ฟอร์ม ก็ให้ส่งผู้ใช้กลับไปยังหน้าฟอร์ม (insert_form.php) ทันที
        exit;
    }
    if(trim($name)=="")//ถ้าช่องกรอกชื่อ ($name) ถูกเว้นว่างไว้ หรือผู้ใช้กรอกมาแต่ช่องว่าง"
    {
        header("Location: insert_form.php?return=1"); //ให้เปลี่ยนหน้าผู้ใช้กลับไปยัง insert_form.php ทันที และแนบรหัสข้อผิดพลาด error=1 ไปด้วย
        exit;
    }
    if(trim($surname)=="")
    {
        header("Location: insert_form.php?return=2"); 
        exit;
    }
    if(trim($phone)=="")
    {
        header("Location: insert_form.php?return=3"); 
        exit;
    }
    if(trim($email)=="")
    {
        header("Location: insert_form.php?return=4"); 
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        header("Location: insert_form.php?return=5"); 
        exit;
    }
   
    
   // 3. หาก Validation ผ่านทั้งหมด (ข้อมูลครบถ้วน) ค่อยลบคุกกี้ที่ใช้เก็บค่าชั่วคราวออกไป
   //setcookie("id", "", time() - 3600, "/"); 
   //setcookie("name", "", time() - 3600, "/"); 
   //setcookie("surname", "", time() - 3600, "/"); 
   //setcookie("phone", "", time() - 3600, "/"); 
   //setcookie("email", "", time() - 3600, "/");
    
   $isSuccess = updateCustomer($id,$name, $surname, $phone, $email);
    
   session_unset();
   session_destroy();
   
   
?>
<html>
    <head>
        <meta charset="UTF-8">
        
    </head>
    <body>
        <h1><?php echo $isSuccess ? "Update สำเร็จ" : "ล้มเหลว"; ?></h1>
        </br>
            <a href="index.html">กลับหน้าหลัก</a>
        </br>
            <a href="insert_form.php">กลับหน้า insert new customer</a>  

        </body>
</html>
