<?php
include '../common/config.php';
if(!isset($_SESSION['admin_id'])) header("Location: login.php");

if(isset($_GET['approve_dep'])){
    $id = $_GET['approve_dep'];
    $d = $conn->query("SELECT * FROM deposits WHERE id=$id")->fetch_assoc();
    $conn->query("UPDATE deposits SET status='Completed' WHERE id=$id");
    $conn->query("UPDATE users SET wallet_balance = wallet_balance + {$d['amount']} WHERE id={$d['user_id']}");
    $conn->query("INSERT INTO transactions (user_id, amount, type, description) VALUES ({$d['user_id']}, {$d['amount']}, 'credit', 'Manual Deposit Approved')");
    header("Location: requests.php");
}

if(isset($_GET['approve_wit'])){
    $id = $_GET['approve_wit'];
    $conn->query("UPDATE withdrawals SET status='Completed' WHERE id=$id");
    header("Location: requests.php");
}

include 'common/header.php';
?>
<h2 class="font-bold mb-4 uppercase text-yellow-500">Deposit Requests</h2>
<div class="space-y-3 mb-10">
    <?php
    $res = $conn->query("SELECT d.*, u.username FROM deposits d JOIN users u ON d.user_id=u.id WHERE d.status='Pending'");
    while($r = $res->fetch_assoc()): ?>
    <div class="bg-gray-800 p-4 rounded-xl flex justify-between items-center border-l-4 border-yellow-500">
        <div><p class="text-sm font-bold"><?php echo $r['username']; ?></p><p class="text-xs text-yellow-500">₹<?php echo $r['amount']; ?></p><p class="text-[8px] text-gray-500">TXN: <?php echo $r['transaction_id']; ?></p></div>
        <a href="?approve_dep=<?php echo $r['id']; ?>" class="bg-green-600 px-3 py-1 rounded text-xs font-bold uppercase">Approve</a>
    </div>
    <?php endwhile; ?>
</div>

<h2 class="font-bold mb-4 uppercase text-green-500">Withdrawal Requests</h2>
<div class="space-y-3">
    <?php
    $res = $conn->query("SELECT w.*, u.username, u.upi_id FROM withdrawals w JOIN users u ON w.user_id=u.id WHERE w.status='Pending'");
    while($r = $res->fetch_assoc()): ?>
    <div class="bg-gray-800 p-4 rounded-xl flex justify-between items-center border-l-4 border-green-500">
        <div><p class="text-sm font-bold"><?php echo $r['username']; ?></p><p class="text-xs text-green-500">₹<?php echo $r['amount']; ?></p><p class="text-[8px] text-gray-500 italic">UPI: <?php echo $r['upi_id']; ?></p></div>
        <a href="?approve_wit=<?php echo $r['id']; ?>" class="bg-blue-600 px-3 py-1 rounded text-xs font-bold uppercase">Mark Paid</a>
    </div>
    <?php endwhile; ?>
</div>
<?php include 'common/bottom.php'; ?>