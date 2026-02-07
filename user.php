<?php
include '../common/config.php';
if(!isset($_SESSION['admin_id'])) header("Location: login.php");
include 'common/header.php';
?>
<h2 class="text-xl font-bold mb-4 italic">REGISTERED USERS</h2>
<div class="space-y-2">
    <?php
    $res = $conn->query("SELECT * FROM users ORDER BY wallet_balance DESC");
    while($u = $res->fetch_assoc()): ?>
    <div class="bg-gray-800 p-3 rounded-xl flex justify-between items-center">
        <div><p class="font-bold text-sm"><?php echo $u['username']; ?></p><p class="text-[10px] text-gray-400"><?php echo $u['email']; ?></p></div>
        <p class="font-bold text-green-500 text-sm">₹<?php echo $u['wallet_balance']; ?></p>
    </div>
    <?php endwhile; ?>
</div>
<?php include 'common/bottom.php'; ?>