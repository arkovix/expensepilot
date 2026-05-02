<?php 
include 'db.php';
session_start();
if(isset($_SESSION['id'])){
$id=$_SESSION['id'];
$srow=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM user WHERE id='$id'"));
$total=mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(amount) as total FROM expense WHERE cust_id = $id"))
?>

<head>
    <link href="transaction.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Smokum&display=swap" rel="stylesheet">    
</head>

<body>
    <div class="main">
        <div class="navt"><?php include 'nav.html' ?></div>
        <div class="mainta">
            <div class="up">
                <img src="asset/menu.png" alt="menu" width="30px" height="30px" id="menu" onclick="menu()">
                <h1>Transaction</h1>
                <p>Track and manage all your expenses here</p>
            </div>
            <div class="down"> 
                <div class="tab">
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Amount</th>
                        </tr>
                        <?php 
                        $query=mysqli_query($conn,"SELECT * FROM expense WHERE cust_id='$id'");
                        while($rowt=mysqli_fetch_assoc($query)){
                        ?>
                        <tr>
                            <td><?php echo $rowt['date']?></td>
                            <td><?php echo $rowt['description']?></td>
                            <td><?php echo $rowt['category']?></td>
                            <td><?php echo $rowt['amount']?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
                <div class="summary">
                    <h2>Summary</h2>
                    <table>
                        <tr>
                            <td>Spending</td>
                            <td>₹<?php echo $total['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Income</td>
                            <td>₹<?php echo $srow['budget'];?></td>
                        </tr>
                        <tr>
                            <td>Balance</td>
                            <td>₹<?php echo $srow['budget']-$total['total'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div> 
    <div class="foot"><?php include 'footer.html'; ?></div>
</body>
<?php }
else{
    echo "<a href='login.php'>Login first</a>";
}?>
</html>

<script>
    function menu(){
        let t=document.querySelector('.navt');
        if(t.style.display=="none"){
            t.style.display="block";
        }
        else{
            t.style.display="none";
        }
    }
</script>