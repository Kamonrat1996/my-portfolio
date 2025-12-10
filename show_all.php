<?php
      // ✅ เรียกใช้ไฟล์ฟังก์ชันสำหรับจัดการข้อมูลลูกค้า
      require_once("customer_function.php");

    ?>

<!DOCTYPE html>
<html >
  <head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $( document ).ready(function() 
        {
            loadTable () ;
        });

        function loadTable () 
        {
             $("#table").load("show_all_customer_table.php" , function(responseText, statusTxt, xhr)
             {

             });
        }
        function confirm_delete(id)
        {
            var r = confirm("คุณจะลบ id " + id + " จริงๆ เหรอ");
            if (r == true) 
            {
                //window.open("delete_customer.php?id="+id,"_self");
                $("#data").load("delete_customer.php?id="+id, function(responseText, statusTxt, xhr) 
                    {
                        console.log("b");
                        if (statusTxt == "success")
                        {
                            loadTable () ;
                        }
                            
                        else  if (statusTxt == "error")
                        {
                                alert("Error: " + xhr.status + ": " + xhr.statusText);
                        }
                    });
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
      <div id="data"></div>
      <div id="table"></div>
      
    </br>
    <a href="index.html">back</a>
    </body>
    </html>