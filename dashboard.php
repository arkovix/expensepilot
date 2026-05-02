<?php
include "db.php";
session_start();
$succes=false;
$c=0;
$itemid;
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    if(isset($_POST['save'])){
        $des=$_POST['name'];
        $ca=$_POST['categ'];
        $amo=$_POST['amount'];
        $date=$_POST['date'];

        $ins="INSERT INTO expense (`cust_id`,`description`, `category`, `amount`, `date`) VALUES ('$id','$des','$ca','$amo','$date')";
        $query=mysqli_query($conn,$ins);
        if($query){
            $succes=true;
            header("location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        
    }
    
    if(isset($_GET['update'])){
        $itd=$_SESSION['iid'];
        //echo $itd;
        $des=$_GET['name'];
        $ca=$_GET['categ'];
        $amo=$_GET['amount'];
        $date=$_GET['date'];

        $queryup=mysqli_query($conn,"UPDATE expense SET description='$des', category='$ca', amount='$amo', date='$date' WHERE sl_no='$itd'");
        if($queryup){
            echo "<p style='color:green; font-size: 30px'>Update success</p>";;
        }
    }
?>

    <head>
        <title>Dashboard</title>
        <link href="dashboard.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Mozilla+Text:wght@200..700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Story+Script&display=swap" rel="stylesheet">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        
            <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Category', 'Amount per Category'],
          ['Food',     <?php $s=0;
          $f=mysqli_query($conn,"SELECT amount FROM expense WHERE category='Food' AND cust_id=$id");
            while ($frow=mysqli_fetch_assoc($f)){
                $s=$s+$frow['amount'];
            }
            echo $s; ?>],
          ['Housing',      <?php $s=0;
          $f=mysqli_query($conn,"SELECT amount FROM expense WHERE category='Housing' AND cust_id=$id");
            while ($frow=mysqli_fetch_assoc($f)){
                $s=$s+$frow['amount'];
            }
            echo $s; ?>],
          ['Transportation',  <?php $s=0;
          $f=mysqli_query($conn,"SELECT amount FROM expense WHERE category='Transportation' AND cust_id=$id");
            while ($frow=mysqli_fetch_assoc($f)){
                $s=$s+$frow['amount'];
            }
            echo $s; ?>],
          ['Utilities', <?php $s=0;
          $f=mysqli_query($conn,"SELECT amount FROM expense WHERE category='Utilities' AND cust_id=$id");
            while ($frow=mysqli_fetch_assoc($f)){
                $s=$s+$frow['amount'];
            }
            echo $s; ?>],
          ['Healthcare',    <?php $s=0;
          $f=mysqli_query($conn,"SELECT amount FROM expense WHERE category='Healthcare' AND cust_id=$id");
            while ($frow=mysqli_fetch_assoc($f)){
                $s=$s+$frow['amount'];
            }
            echo $s; ?>],
          ['Investment',    <?php $s=0;
          $f=mysqli_query($conn,"SELECT amount FROM expense WHERE category='Investment' AND cust_id=$id");
            while ($frow=mysqli_fetch_assoc($f)){
                $s=$s+$frow['amount'];
            }
            echo $s; ?>],
          ['Entertainment',    <?php $s=0;
          $f=mysqli_query($conn,"SELECT amount FROM expense WHERE category='Entertainment' AND cust_id=$id");
            while ($frow=mysqli_fetch_assoc($f)){
                $s=$s+$frow['amount'];
            }
            echo $s; ?>],
          ['Others',    <?php $s=0;
          $f=mysqli_query($conn,"SELECT amount FROM expense WHERE category='Others' AND cust_id=$id");
            while ($frow=mysqli_fetch_assoc($f)){
                $s=$s+$frow['amount'];
            }
            echo $s; ?>]
        ]);

        var options = {
          title: 'Category wise expense',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
      function menu(){
                let t=document.querySelector('.nav1');
                if(t.style.display=="none"){
                    t.style.display="block";
                }
                else{
                    t.style.display="none";
                }
            }
    </script>     
    </head>
        <div class="main">
            <div class="nav1"><?php include 'nav.html' ?></div>
            <div class="maindas">
                <div class="welc"> 
                    <img src="asset/menu.png" alt="menu" width="30px" height="30px" id="menu" onclick="menu()"> 
                    <img src="asset/profile.png" width="35px" height="35px">
                    <h1>Hello, <?php
                    $row=mysqli_fetch_assoc(mysqli_query($conn,"SELECT fname FROM user WHERE id=$id"));
                    echo $row['fname'];
                    ?>
                    </h1>
                </div>
                <div class="da">
                    <div class="leftmain">
                        <div class="addexp"><?php
                            if(isset($_GET['itemid'])){
                                    $_SESSION['iid']=$_GET['itemid'];
                                    $itd=$_SESSION['iid'];
                                    $irow=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM expense WHERE sl_no=$itd"))?>
                            <h2>Update Expense</h2>
                            <form method="GET">
                                <label for="des">Description:</label>
                                <input type="text" id="des" name="name" placeholder="Enter description..." 
                                value="<?php echo $irow['description'] ?>"required><br>
                                <label for="cat">Category:</label>
                                <select id="cat" name="categ" value="" required>
                                    <option><?php echo $irow['category'] ?></option>
                                    <option>Food</option>
                                    <option>Housing</option>
                                    <option>Transportation</option>
                                    <option>Utilities</option>
                                    <option>Healthcare</option>
                                    <option>Investment</option>
                                    <option>Entertainment</option>
                                    <option>Others</option>
                                </select><br>
                                <label for="am">Amount:</label>
                                <input type="num"
                                value="<?php echo $irow['amount'] ?>" name="amount" placeholder="Amount" id="am" required ><br>
                                <label for="da">Date:</label>
                                <input type="date" name="date" id="da"
                                value="<?php echo $irow['date'] ?>"><br>
                                <button name="update" type="submit">Update Expense</button>
                            <?php }
                            else{?>
                            <h2>Add New Expense</h2>
                            <form method="POST">
                                <label for="des">Description:</label>
                                <input type="text" id="des" name="name" placeholder="Enter description..." required><br>
                                <label for="cat">Category:</label>
                                <select id="cat" name="categ" value="" required>
                                    <option>Food</option>
                                    <option>Housing</option>
                                    <option>Transportation</option>
                                    <option>Utilities</option>
                                    <option>Healthcare</option>
                                    <option>Investment</option>
                                    <option>Entertainment</option>
                                    <option>Others</option>
                                </select><br>
                                <label for="am">Amount:</label>
                                <input type="num" name="amount" placeholder="Amount" id="am" required ><br>
                                <label for="da">Date:</label>
                                <input type="date" name="date" id="da"><br>
                                <button name="save" type="submit">Add Expense</button>
                                
                                <?php
                                if($succes){
                                    echo "<p style='color:green; font-size: 30px'>Successfully added</p>";
                                    } 
                                    ?>
                                <?php } ?>
                            </form>
                        </div>
                        <div class="explist">
                            <h2>Todays Expenses</h2>
                            <table>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Description</th>
                                    <th>Catagory</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                                <?php 
                                $result=mysqli_query($conn,"SELECT * FROM expense WHERE cust_id=$id");
                                while($row=mysqli_fetch_assoc($result)){ ?>
                                <tr>
                                    <td><?php 
                                    $c++;
                                    echo $c ?></td>
                                    <td><?php echo $row['description'] ?></td>
                                    <td><?php echo $row['category'] ?></td>
                                    <td><?php echo $row['amount'] ?></td>
                                    <td><a href="dashboard.php?itemid=<?php echo $row['sl_no']?>"><img src="asset/edit.png" width="20px" height="20px" alt="editimage"></a> <a href="delete.php?id=<?php echo $row['sl_no']?>"><img src="asset/trash.png" width="20px" height="20px" alt="deleteimage"></a></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>

                    <div class="rightmain">
                        <div class="view">
                            <h2>Overview</h2>
                            <div class="cards">
                                <div class="scards">
                                    <p>Total Spend</p>
                                    <b><?php 
                                $result=mysqli_query($conn,"SELECT * FROM expense WHERE cust_id=$id");
                                $ta=0;
                                while($row=mysqli_fetch_assoc($result)){
                                    $ta=$ta+$row['amount'];
                                }
                                echo $ta.".00";?></b>
                                </div>
                                <div class="scards">
                                    <p>Monthly Spending</p>
                                    <b><?php
                                    $cd=date("Y-m-d");
                                    $drow=mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(amount) AS msa FROM expense WHERE cust_id=$id AND MONTH(date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND YEAR(date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)"));
                                    echo $drow['msa'];
                                    ?></b>
                                </div>
                                <div class="scards">
                                    <p>Available Spending</p>
                                    <b>₹<?php
                                    $burow=mysqli_fetch_assoc(mysqli_query($conn,"SELECT budget FROM user WHERE id=$id"));
                                    echo $burow['budget']-$ta;
                                    ?></b>
                                </div>
                            </div>
                        </div>
                        <div class="chartcat">
                            <div id="piechart_3d"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.html';
        }
    else{
        echo "<a href='login.php'>Login first</a>";
    } ?>
    </body>
</html>