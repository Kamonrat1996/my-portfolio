<?php
  
    require_once("customer_function.php");

   
    $allcustomers = getAllCustomer();

   
    if (count($allcustomers) > 0) {

        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr>";

        //  ดึงชื่อคอลัมน์ (keys) จากแถวแรก
        $keys = array_keys($allcustomers[0]);

    //  สร้างหัวตาราง (ใช้ for)
    for ($i = 0; $i < count($keys); $i++) 
    {
        echo "<th>" . ($keys[$i]) . "</th>";
    }
    echo "<th>"."แก้ไข"."</th>";
    echo "<th>"."ลบ"."</th>";
    echo "</tr>";

    //  วนลูปแสดงข้อมูลแต่ละแถว 
    for ($i = 0; $i < count($allcustomers); $i++) 
    {
        // ถ้าเป็นแถวคู่ (0, 2, 4) ให้พื้นหลังชมพู
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
else 
{
    echo "<p>ไม่มีข้อมูลลูกค้า</p>";
}

?>
