<?php
include '../common/config.php';
$msg = "";
if(isset($_POST['admin_login'])) {
    $u = clean($_POST['user']); $p = $_POST['pass'];
    $res = $conn->query("SELECT * FROM admin WHERE username='$u'");
    if($a = $res->fetch_assoc()) {
        if(password_verify($p, $a['password'])) {
            $_SESSION['admin_id'] = $a['id'];
            header("Location: index.php");
        } else { $msg = "Invalid Password!"; }
    } else { $msg = "Invalid Admin!"; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Admin Login</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-black text-white flex items-center justify-center min-h-screen p-6">
    <form method="POST" class="bg-gray-900 p-8 rounded-3xl w-full max-w-sm border border-gray-800 shadow-2xl">
        <h1 class="text-2xl font-black mb-6 text-red-600 text-center uppercase tracking-tighter italic">Admin Login</h1>
        <?php if($msg) echo "<p class='text-red-500 text-center mb-4 text-xs'>$msg</p>"; ?>
        <input type="text" name="user" placeholder="Admin Username" class="w-full bg-gray-800 p-4 rounded-xl mb-4 border border-gray-700 outline-none" required>
        <input type="password" name="pass" placeholder="Password" class="w-full bg-gray-800 p-4 rounded-xl mb-6 border border-gray-700 outline-none" required>
        <button name="admin_login" class="w-full bg-red-600 py-4 rounded-xl font-bold uppercase shadow-lg shadow-red-600/20">Access Panel</button>
    </form>
</body>
</html>