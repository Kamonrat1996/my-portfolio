<?php

require_once("customer_function.php");
session_start();

$isEdit = false;
//  ตรวจสอบว่ามีการส่งค่า action ผ่าน URL และค่าของ action คือ "edit" หรือไม่
if (isset($_GET['action']) && $_GET['action'] == "edit") 
{
    $isEdit = true;
    $id = $_GET['id'];

    
    $allcustomers = getCustomerById($id);

   
    if (count($allcustomers) > 0) {

        //  ดึงข้อมูลลูกค้าแถวแรกจากผลลัพธ์ 
        $cust = $allcustomers[0];

        // ดึงค่าชื่อ-นามสกุล-เบอร์โทร-อีเมล จาก array ของลูกค้า
        $name    = $cust['name'];
        $surname = $cust['surname'];
        $phone   = $cust['phone'];
        $email   = $cust['email'];

        // ตั้งอายุคุกกี้ (1 วัน = 60 วินาที * 60 นาที * 24 ชั่วโมง)
        //$expiry_time = time() + (60 * 60 * 24);

        //  สร้าง/อัปเดตคุกกี้ เพื่อเก็บข้อมูลลูกค้าไว้ชั่วคราว
        //   เช่น ใช้ในกรณีกรอกฟอร์มผิดพลาด แล้วจะดึงค่ากลับมาแสดงอีกครั้ง
       // setcookie("name", $name, $expiry_time, "/");
        //setcookie("surname", $surname, $expiry_time, "/");
        //setcookie("phone", $phone, $expiry_time, "/");
        //setcookie("email", $email, $expiry_time, "/");

        $_SESSION['name']    = $name;
        $_SESSION['surname'] = $surname;
        $_SESSION['phone']   = $phone;
        $_SESSION['email']   = $email;

        // อัปเดตตัวแปร $_COOKIE ในหน้านี้โดยตรง
        //  เพื่อให้สามารถเข้าถึงค่าคุกกี้ได้ทันที (ปกติคุกกี้จะใช้ได้ใน request ถัดไป)
        //$_COOKIE["name"] = $name;
        //$_COOKIE["surname"] = $surname;
        //$_COOKIE["phone"] = $phone;
        //$_COOKIE["email"] = $email; 
    }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Books store [Customer]</title>
  </head>

  <body>
    <h1>insert new Customer</h1> 

    <?php

    

    if (isset($_GET['return']) && $_GET['return']==1) //ถ้า มี พารามิเตอร์ชื่อ return อยู่ใน URL และ ค่าของพารามิเตอร์ return นั้น เท่ากับ 1
    {
        echo '<p style="color: blue; font-weight: bold;">กรุณากรอกชื่อของคุณ</p>';
    }
    else if (isset($_GET['return']) && $_GET['return']==2) 
    {
        echo '<p style="color: blue; font-weight: bold;">กรุณากรอกนามสกุลของคุณ</p>';
    }
    else if (isset($_GET['return']) && $_GET['return']==3) 
    {
        echo '<p style="color: blue; font-weight: bold;">กรุณากรอกเบอร์โทรศัพท์ของคุณ</p>';
    }
    else if (isset($_GET['return']) && $_GET['return']==4) 
    {
        echo '<p style="color: blue; font-weight: bold;">กรุณากรอกอีเมล์ของคุณ</p>';
    }else if (isset($_GET['return']) && $_GET['return']==5) 
    {
        echo '<p style="color: blue; font-weight: bold;">email ไม่ถูก format นะคะๆ</p>';
    }

?>
  <h1></h1>
    <?php
    if($isEdit)
    {
      echo "<form action='update_action.php' method='POST'>";
    }
    else
    { 
      echo "<form action='insert_action.php' method='POST'>";
    }
    ?>
    <ul>

    <?php

      if($isEdit)
      {
        echo "<input type='hidden' name='id' value='$id' />";
      }

    ?>
      <li>name <input type="text" name="name" value="<?php echo       ($_SESSION["name"] ?? ''); ?>"/></li>
      <li>surname <input type="text" name="surname" value="<?php echo ($_SESSION["surname"] ?? ''); ?>"/></li>
      <li>phone <input type="text" name="phone" value="<?php echo     ($_SESSION["phone"] ?? ''); ?>"/></li>
      <li>email <input type="text" name="email" value="<?php echo     ($_SESSION["email"] ?? ''); ?>"/></li>
      <li> <input type="submit" name="submit" value="save"/></li>
    </ul>
    </form>

    
   
    



  </body>

</html>
