<?php

function createMysqlConnection()
{
    // 🔹 ข้อมูลเชื่อมต่อฐานข้อมูล
    $servername = "localhost";
    $username   = "root";
    $password   = "";          
    $dbname     = "php_crud"; 

    // 🔹 สร้างการเชื่อมต่อ
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 🔹 ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function insertNewCustomer($name, $surname, $phone, $email)
{
    $conn = createMysqlConnection();
    
    // คำสั่ง SQL สำหรับเพิ่มข้อมูลลูกค้า
    $sql = "
        INSERT INTO customers (id, name, surname, phone, email) 
        VALUES (0,?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $surname, $phone, $email);   

    // ประกาศตัวแปรและกำหนดค่าเริ่มต้น
    $isSuccess = false; 
    
    if ($stmt->execute() === TRUE) 
    {
        // หากการดำเนินการสำเร็จ
        $isSuccess = true;
    } else 
    {
        // หากเกิดข้อผิดพลาด ให้แสดงข้อความผิดพลาด
        echo " Error: " . $sql . "<br>" . $conn->error;
    }

    // ปิดการเชื่อมต่อ
    $conn->close();
    // ส่งคืน (return) ค่าสถานะความสำเร็จ (true หรือ false)
    return $isSuccess;
}

function getAllCustomer()
{
    $conn = createMysqlConnection();

    $sql = "SELECT * from customers ORDER BY id ";
    $result = $conn->query($sql);

    $allcustomers = array();
        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc())
            {
            // id    name    surname phone email insert_time
            $allcustomers_row = array("id"=>$row["id"],
                                "name"=>$row["name"],
                                "surname"=>$row["surname"],
                                "phone"=>$row["phone"],
                                "email"=>$row["email"],
                                "insert_time"=>$row["insert_time"],
            );
            array_push($allcustomers, $allcustomers_row);
            }
        } else 
        {
            echo "0 results";
        }

    //  ปิดการเชื่อมต่อ
    $conn->close();
    return $allcustomers;
}

function searchCustomerByName($name_search)
{
    $conn = createMysqlConnection();

    $sql = "SELECT * FROM customers WHERE `name` LIKE ? "; 
    echo "$sql";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name_search);
    $stmt->execute();
    $result = $stmt->get_result();

    $allcustomers = array();
        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc())
            {
            // id    name    surname phone email insert_time
            $allcustomers_row = array("id"=>$row["id"],
                                "name"=>$row["name"],
                                "surname"=>$row["surname"],
                                "phone"=>$row["phone"],
                                "email"=>$row["email"],
                                "insert_time"=>$row["insert_time"],
            );
            array_push($allcustomers, $allcustomers_row);
            }
        } else 
        {
            echo "0 results";
        }

    
    $conn->close();
    $stmt->close();
    return $allcustomers;
}

function getCustomerById($id)
{
    $conn = createMysqlConnection();

    $sql = "SELECT * from customers WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $result =  $stmt->get_result(); 
    

    $allcustomers = array();
        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc())
            {
            // id    name    surname phone email insert_time
            $allcustomers_row = array("id"=>$row["id"],
                                "name"=>$row["name"],
                                "surname"=>$row["surname"],
                                "phone"=>$row["phone"],
                                "email"=>$row["email"],
                                "insert_time"=>$row["insert_time"],
            );
            array_push($allcustomers, $allcustomers_row);
            }
        } else 
        {
            echo "0 results";
        }

   
    $conn->close();
    $stmt->close();
    return $allcustomers;
}

function deletecustomer($id)
{
    $conn = createMysqlConnection();
    
    // **ป้องกัน SQL Injection 
    $id_safe = $conn->real_escape_string($id); 

    $sql = "DELETE FROM customers WHERE id = ?" ;
    $stmt = $conn->prepare( $sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute() === TRUE) 
    {
        // หากลบสำเร็จ: ไม่ต้อง echo อะไรเลย 
        $conn->close();
        return true; // ส่งค่า true กลับไป
    } else 
    {
        // หากล้มเหลว: แสดง  Error 
        echo " Error: " . $sql . "<br>" . $conn->error;
        $conn->close();
        $stmt->close();
        return false; // ส่งค่า false กลับไป
    }

}

function updateCustomer($id,$name, $surname, $phone, $email)
{
    $conn = createMysqlConnection();
    
    // คำสั่ง SQL สำหรับเพิ่มข้อมูลลูกค้า
    $sql = "UPDATE  customers SET name = ?,
                    surname = ?,
                    phone = ?,
                    email = ?
                    WHERE id = ?;";

    echo $sql."<br/>";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $surname, $phone, $email, $id); 
    // ประกาศตัวแปรและกำหนดค่าเริ่มต้น
    $isSuccess = false; 
    
    if ($stmt->execute() === TRUE) 
    {
        // หากการดำเนินการสำเร็จ
        $isSuccess = true;
    } else 
    {
        // หากเกิดข้อผิดพลาด ให้แสดงข้อความผิดพลาด
        echo " Error: " . $sql . "<br>" . $conn->error;
    }

    // ปิดการเชื่อมต่อ
    $conn->close();
    $stmt->close();
    // ส่งคืน (return) ค่าสถานะความสำเร็จ (true หรือ false)
    return $isSuccess;
}



?>


