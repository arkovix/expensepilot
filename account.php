<?php
session_start();
include "db.php";
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
if (isset($_SESSION['id'])) {
    $id  = $_SESSION['id'];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id='$id'"));

    if (isset($_POST['update'])) {
        $fname    = $_POST['fname'];
        $lname    = $_POST['lname'];
        $email    = $_POST['email'];
        $incs     = $_POST['insource'];
        $fbudget  = $_POST['fbudget'];
        $hbudget  = $_POST['hbudget'];
        $tbudget  = $_POST['tbudget'];
        $ubudget  = $_POST['ubudget'];
        $hebudget = $_POST['hebudget'];
        $ibudget  = $_POST['ibudget'];
        $enbudget = $_POST['enbudget'];
        $obudget  = $_POST['obudget'];
        $but = $fbudget + $hbudget + $tbudget + $ubudget + $hebudget + $ibudget + $enbudget + $obudget;

        $su = mysqli_query($conn, "UPDATE user SET fname='$fname', lname='$lname', email='$email',
              income='$incs', budget='$but', Food='$fbudget', Housing='$hbudget',
              Transportation='$tbudget', Utilities='$ubudget', Healthcare='$hebudget',
              Investment='$ibudget', Entertainment='$enbudget', Others='$obudget' WHERE id=$id");
        if ($su) {
            //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'arkovix7@gmail.com';                     //SMTP username
                    $mail->Password   = 'dmrdssixbkawblbi';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('arkovix7@gmail.com', 'ExpensePilot');
                    $mail->addAddress($email);     //Add a recipient

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Registration Success in ExpensePilot';
                    $mail->Body    = "<p><h4>Update successfull.</h4></p>";
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                } catch (Exception $e) {
                    echo "<script>alert('Email could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
                }
            header("location: dashboard.php");
            exit();
        }

    } elseif (isset($_POST['upass'])) {
        $pass  = $_POST['passw'];
        $cpass = password_hash($pass, PASSWORD_BCRYPT);
        if (mysqli_query($conn, "UPDATE user SET password='$cpass' WHERE id=$id")) {
            //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'arkovix7@gmail.com';                     //SMTP username
                    $mail->Password   = 'dmrdssixbkawblbi';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('arkovix7@gmail.com', 'ExpensePilot');
                    $mail->addAddress($email);     //Add a recipient

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Registration Success in ExpensePilot';
                    $mail->Body    = "Password update successfull <br>
                                    <p><b>New Password:</b> $pass</p>";
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                } catch (Exception $e) {
                    echo "<script>alert('Email could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
                }
            header("location: dashboard.php");
            exit();
        }
    }

    /* helpers */
    function bval($row, $col, $def, $budget) {
        return ($row[$col] == NULL) ? round($def * $budget, 2) : $row[$col];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Settings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="account.css?v=3" rel="stylesheet">
</head>
<body>

<!-- ── PAGE HEADER ───────────────────────────────── -->
<header class="page-header">
    <a href="dashboard.php">← Dashboard</a>
    <h1>ExpensePilot</h1>
</header>

<!-- ── PROFILE HERO ──────────────────────────────── -->
<div class="profile-hero">
    <div class="avatar-wrap">
        <span class="avatar-ring"></span>
        <img src="asset/profile.png" alt="Profile">
    </div>
    <h2><?php echo htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?></h2>
    <span class="badge"><?php echo htmlspecialchars($row['income'] ?: 'User'); ?></span>
</div>

<div class="wrapper">

    <!-- ── PERSONAL DETAILS CARD ─────────────────── -->
    <div class="card">
        <p class="card-title"><span class="dot"></span>Personal Details</p>
        <form method="post" onsubmit="return check()">
            <div class="form-grid">

                <div class="form-group">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname"
                           value="<?php echo htmlspecialchars($row['fname']); ?>"
                           placeholder="First name">
                </div>

                <div class="form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname"
                           value="<?php echo htmlspecialchars($row['lname']); ?>"
                           placeholder="Last name">
                </div>

                <div class="form-group full">
                    <label for="mail">Email Address</label>
                    <input type="email" id="mail" name="email"
                           value="<?php echo htmlspecialchars($row['email']); ?>"
                           placeholder="your@email.com">
                </div>

                <div class="form-group">
                    <label for="inc">Income Source</label>
                    <div class="select-wrap">
                        <select id="inc" name="insource" required>
                            <option value="<?php echo htmlspecialchars($row['income']); ?>">
                                <?php echo htmlspecialchars($row['income']); ?>
                            </option>
                            <option value="Salary">Salary</option>
                            <option value="Business">Business</option>
                            <option value="Student">Student</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mbudget">Monthly Budget (₹)</label>
                    <input type="number" id="mbudget" name="mbu"
                           value="<?php echo $row['budget']; ?>"
                           placeholder="0.00" step="0.01" min="0">
                </div>

            </div><!-- /form-grid -->

            <!-- ── CATEGORY BUDGETS ─────────────── -->
            <p class="card-title" style="margin-top:32px"><span class="dot" style="background:var(--accent2)"></span>Category Budgets</p>

            <div class="budget-grid">

                <?php
                $cats = [
                    ['Food',           'fbudget',  0.20, '🍛'],
                    ['Housing',        'hbudget',  0.30, '🏠'],
                    ['Transportation', 'tbudget',  0.10, '🚌'],
                    ['Utilities',      'ubudget',  0.10, '💡'],
                    ['Healthcare',     'hebudget', 0.05, '🩺'],
                    ['Investment',     'ibudget',  0.10, '📈'],
                    ['Entertainment',  'enbudget', 0.10, '🎬'],
                    ['Others',         'obudget',  0.05, '📦'],
                ];
                foreach ($cats as [$col, $name, $def, $icon]):
                    $val = bval($row, $col, $def, $row['budget']);
                ?>
                <div class="budget-item">
                    <label>
                        <span class="icon"><?php echo $icon; ?></span>
                        <?php echo $col; ?>
                    </label>
                    <input type="number" name="<?php echo $name; ?>"
                           id="<?php echo strtolower($col); ?>"
                           step="0.01" min="0"
                           value="<?php echo $val; ?>">
                </div>
                <?php endforeach; ?>

            </div><!-- /budget-grid -->

            <!-- total strip -->
            <div class="budget-total">
                <span>Total allocated</span>
                <strong id="liveTotal">₹0.00</strong>
            </div>
            <p id="warn-msg">⚠ Category total exceeds monthly budget</p>

            <button type="submit" name="update" class="btn btn-primary">Save Changes</button>
        </form>
    </div><!-- /card -->

    <!-- ── CHANGE PASSWORD CARD ───────────────────── -->
    <div class="card">
        <p class="card-title"><span class="dot" style="background:#ff4d6d"></span>Change Password</p>
        <form method="post">
            <div class="form-group">
                <label for="passw">New Password</label>
                <div class="pass-wrap">
                    <input type="password" id="passw" name="passw" placeholder="Enter new password">
                    <button type="button" class="pass-toggle" onclick="togglePass()" title="Show/hide">👁</button>
                </div>
            </div>
            <button type="submit" name="upass" class="btn btn-secondary">Update Password</button>
        </form>
    </div><!-- /card -->

</div><!-- /wrapper -->

<script>
/* live budget total */
const budgetIds = ['food','housing','transportation','utilities','healthcare','investment','entertainment','others'];
const liveTotal = document.getElementById('liveTotal');
const warnMsg   = document.getElementById('warn-msg');
const mbudgetEl = document.getElementById('mbudget');

function updateTotal() {
    let sum = 0;
    budgetIds.forEach(id => {
        sum += Number(document.getElementById(id)?.value || 0);
    });
    liveTotal.textContent = '₹' + sum.toFixed(2);
    const mval = Number(mbudgetEl.value || 0);
    const over = mval > 0 && sum > mval;
    liveTotal.style.color = over ? 'var(--danger)' : 'var(--accent)';
    warnMsg.style.display  = over ? 'block' : 'none';
}

budgetIds.forEach(id => {
    document.getElementById(id)?.addEventListener('input', updateTotal);
});
mbudgetEl.addEventListener('input', updateTotal);
updateTotal();

/* form submit guard */
function check() {
    const mbudget = Number(mbudgetEl.value);
    let sum = 0;
    budgetIds.forEach(id => { sum += Number(document.getElementById(id)?.value || 0); });
    if (sum > mbudget) {
        return confirm(
            "Category budgets exceed your monthly budget.\n\n" +
            "Adjust categories or increase monthly budget.\n\n" +
            "Continue anyway?"
        );
    }
    return true;
}

/* password toggle */
function togglePass() {
    const inp = document.getElementById('passw');
    inp.type = inp.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>
<?php
} else { ?>
    <div class="login-prompt">
        <span>You're not logged in</span>
        <a href="login.php">Log In</a>
    </div>
<?php } ?>