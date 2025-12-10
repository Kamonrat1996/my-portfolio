<?php
      // ✅ เรียกใช้ไฟล์ฟังก์ชันสำหรับจัดการข้อมูลลูกค้า
    require_once("customer_function.php");

?>

<!DOCTYPE html>
<html >
  <head>
    <script>
      function confirm_delete(id)
      {
          var r = confirm("คุณจะลบ id " + id + " จริงๆ เหรอ");
          if (r == true) 
          {
              window.open("delete_customer.php?id="+id,"_self");
          } else 
          {
              
          }
      }
    </script>
        <meta charset="UTF-8">
        <title>Books Store [Customer]</title>
      </head>

      <body>
      <h1>Customers ของเราทั้งหมด</h1>
        <form action="search_customer.php" method="POST">
        search : <input type="text" name="text_to_search" value ="%"/>
            <input type="submit" value="SEARCH" name="btn" />

        </form>

        <br/>
        <br/>

      <?php

        if(isset($_POST['btn']))
        {
        // 1️⃣ เรียกใช้ไฟล์ฟังก์ชันสำหรับเชื่อมต่อฐานข้อมูล
        require_once("customer_function.php");

        // 2️⃣ ดึงข้อมูลลูกค้าทั้งหมด
        $allcustomers = searchCustomerByName($_POST['text_to_search']);

        // 3️⃣ ตรวจสอบว่ามีข้อมูลอย่างน้อยหนึ่งแถวหรือไม่
        if (count($allcustomers) > 0) {

            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr>";

            // 🔹 ดึงชื่อคอลัมน์ (keys) จากแถวแรก
            $keys = array_keys($allcustomers[0]);

            // 🔹 สร้างหัวตาราง (ใช้ for)
            for ($i = 0; $i < count($keys); $i++) 
            {
                echo "<th>" . ($keys[$i]) . "</th>";
            }
            echo "<th>"."แก้ไข"."</th>";
            echo "<th>"."ลบ"."</th>";
            echo "</tr>";

            // 🔹 วนลูปแสดงข้อมูลแต่ละแถว (ใช้ for)
            for ($i = 0; $i < count($allcustomers); $i++) 
            {
              // ถ้าเป็นแถวคู่ (0, 2, 4, ...) ให้พื้นหลังชมพู
              if ($i % 2 == 0) 
              {
                  echo "<tr style='background-color:#FFC0CB;'>";
              } else {
                  echo "<tr>";
              }

              // วนลูปแต่ละคอลัมน์
              for ($j = 0; $j < count($keys); $j++) 
              {
                  $key = $keys[$j];
                  echo "<td>" . htmlspecialchars($allcustomers[$i][$key]) . "</td>";
              }
              $id = $allcustomers[$i]['id'];
              echo "<td><a href='insert_form.php?action=edit&id=$id'>แก้ไข</a></td>";
              echo "<td><button onclick='confirm_delete(" . $id . ")'>ลบ</button></td>";
              
              echo "</tr>";
          }

          echo "</table>";
        }
      } 
      else 
      {
          echo "<p>กรุณากดปุ่ม search ค่ะ</p>";
      }
    ?>
    </br>
    <a href="index.html">back</a>
    </body>
    </html>