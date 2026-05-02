<?php
include "db.php";
session_start();
if(isset($_SESSION['id'])){
$id=$_SESSION['id'];
$query = "SELECT category, SUM(amount) as total FROM expense WHERE cust_id = $id GROUP BY category";

$result = mysqli_query($conn, $query);

$data = [];
while($row = mysqli_fetch_assoc($result)){
    $data[$row['category']] = $row['total'];
}
?>
<head>
    <link href="budget.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Average+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Smokum&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Category', 'Amount per Category'],
          ['Food',     <?php echo $data['Food'] ?? 0; ?>],
          ['Housing',      <?php echo $data['Housing'] ?? 0;?>],
          ['Transportation',  <?php echo $data['Transportation'] ?? 0;?>],
          ['Utilities', <?php echo $data['Utilities'] ?? 0;?>],
          ['Healthcare',    <?php echo $data['Healthcare'] ?? 0;?>],
          ['Investment',    <?php echo $data['Investment'] ?? 0;?>],
          ['Entertainment',    <?php echo $data['Entertainment'] ?? 0;?>],
          ['Others',    <?php echo $data['Others'] ?? 0;?>]
        ]);

        var options = {
          title: 'My Monthly Expenses',
          is3D: true,
          fontSize: 20,
          titleTextStyle: {
            fontSize: 28,
            bold: true
          }
          
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }

      function menu(){
                let t=document.querySelector('.nav5');
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
        <div class="nav5"><?php include 'nav.html'; ?></div>
        <div class="mainbudget">
            <div class="head">
                <img src="asset/menu.png" alt="menu" width="30px" height="30px" id="menu" onclick="menu()"> 
                <h1>Budget</h1>
                <p>Manage your monthly budget and track your spending</p>
            </div>
            <div class="card">
                <div class="subcard">
                    <div class="hcard">
                        <b>Budget Amount</b>
                        <h2>₹<?php
                        $bu=mysqli_fetch_assoc(mysqli_query($conn,"SELECT budget FROM user WHERE id = $id"));
                        echo $bu['budget'];
                        ?></h2>
                    </div>
                    <div class="imcard">
                        <img src="asset/investment.png" alt="budget image" width="80px" height="80px">
                    </div>
                </div>
                <div class="subcard">
                    <div class="hcard">
                        <b>Total Spent</b>
                        <h2>₹<?php
                        $ta=mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(amount) AS total FROM expense WHERE cust_id=$id"));
                        echo $ta['total'];
                        ?></h2>
                    </div>
                    <div class="imcard">
                        <img src="asset/spending-money.png" alt="spending money" width="80px" height="80px">
                    </div>
                </div>
                <div class="subcard">
                    <div class="hcard">
                        <b>Remaining Budget</b>
                        <h2>₹<?php echo $bu['budget']-$ta['total'];?></h2>
                    </div>
                    <div class="imcard">
                        <img src="asset/deadline.png" alt="Remaining money" width="80px" height="80px">
                    </div>
                </div>
            </div>
            <div class="submain">
                <div class="left">
                    <div class="leftu">
                        <div id="piechart_3d"></div>
                    </div>
                    <div class="leftd">
                        <h3>Category Budgets</h3>
                        <table>
                            <tr>
                                <th>Category</th>
                                <th>Budget</th>
                                <th>Spent</th>
                                <th>Remaining</th>
                            </tr>
                            <tr>
                                <td>Food</td>
                                <td><?php $cb=$bu['budget']*0.20;
                                echo $cb;?></td>
                                <td><?php $sh=$data['Food'] ?? 0; 
                                echo $sh;?></td>
                                <td><?php echo $cb-$sh?></td>
                            </tr>
                            <tr>
                                <td>Housing</td>
                                <td><?php $cb=$bu['budget']*0.30;
                                echo $cb;?></td>
                                <td><?php $sh=$data['Housing'] ?? 0; 
                                echo $sh;?></td>
                                <td><?php echo $cb-$sh?></td>
                            </tr>
                            <tr>
                                <td>Transportation</td>
                                <td><?php $cb=$bu['budget']*0.10;
                                echo $cb;?></td>
                                <td><?php $sh=$data['Transportation'] ?? 0; 
                                echo $sh;?></td>
                                <td><?php echo $cb-$sh?></td>
                            </tr>
                            <tr>
                                <td>Utilities</td>
                                <td><?php $cb=$bu['budget']*0.10;
                                echo $cb;?></td>
                                <td><?php $sh=$data['Utilities'] ?? 0; 
                                echo $sh;?></td>
                                <td><?php echo $cb-$sh?></td>
                            </tr>
                            <tr>
                                <td>Healthcare</td>
                                <td><?php $cb=$bu['budget']*0.05;
                                echo $cb;?></td>
                                <td><?php $sh=$data['Healthcare'] ?? 0; 
                                echo $sh;?></td>
                                <td><?php echo $cb-$sh?></td>
                            </tr>
                            <tr>
                                <td>Investment</td>
                                <td><?php $cb=$bu['budget']*0.10;
                                echo $cb;?></td>
                                <td><?php $sh=$data['Investment'] ?? 0; 
                                echo $sh;?></td>
                                <td><?php echo $cb-$sh?></td>
                            </tr>
                            <tr>
                                <td>Entertainment</td>
                                <td><?php $cb=$bu['budget']*0.10;
                                echo $cb; ?></td>
                                <td><?php $sh= $data['Entertainment'] ?? 0; 
                                echo $sh;?></td>
                                <td><?php echo $cb-$sh?></td>
                            </tr>
                            <tr>
                                <td>Others</td>
                                <td><?php  $cb=$bu['budget']*0.05;
                                echo $cb;?></td>
                                <td><?php
                                $sh=$data['Others'] ?? 0;
                                echo $sh; ?></td>
                                <td><?php echo $cb-$sh;?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="right">
                    <div class="summary">
                        <h3>Budget Summary</h3>
                        <div class="subsum">
                            <div class="para">
                                <p>Budgeted amount</p>
                                <p>Total spent</p>
                                <p>Remaining Budget</p>
                                <p>Daily Avarage spend</p>
                            </div>
                            <div class="amou">
                                <b>₹<?php echo $bu['budget']?></b>
                                <b>₹<?php echo $ta['total']?></b>
                                <b>₹<?php echo $bu['budget']-$ta['total'];?></b>
                                <b>₹<?php echo $bu['budget']/30;?></b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="foot"><?php include 'footer.html'; ?></div>
    <?php } 
    else{
        echo "<a href='login.php'>Login first</a>";
    }?>
</body>
</html>