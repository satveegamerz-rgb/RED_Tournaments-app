<?php
include '../common/config.php';
if(!isset($_SESSION['admin_id'])) header("Location: login.php");

$u_count = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
$t_count = $conn->query("SELECT COUNT(*) as c FROM tournaments")->fetch_assoc()['c'];
$d_count = $conn->query("SELECT COUNT(*) as c FROM deposits WHERE status='Pending'")->fetch_assoc()['c'];
$w_count = $conn->query("SELECT COUNT(*) as c FROM withdrawals WHERE status='Pending'")->fetch_assoc()['c'];

include 'common/header.php';
?>
<div class="mb-6"><h2 class="text-xl font-bold">Admin Stats</h2></div>
<div class="grid grid-cols-2 gap-4">
    <div class="bg-gray-800 p-4 rounded-2xl border-l-4 border-blue-500">
        <p class="text-[10px] text-gray-500 font-bold uppercase">Total Users</p>
        <h3 class="text-2xl font-black"><?php echo $u_count; ?></h3>
    </div>
    <div class="bg-gray-800 p-4 rounded-2xl border-l-4 border-red-500">
        <p class="text-[10px] text-gray-500 font-bold uppercase">Matches</p>
        <h3 class="text-2xl font-black"><?php echo $t_count; ?></h3>
    </div>
    <a href="requests.php" class="bg-gray-800 p-4 rounded-2xl border-l-4 border-yellow-500">
        <p class="text-[10px] text-gray-500 font-bold uppercase">Pending Dep</p>
        <h3 class="text-2xl font-black text-yellow-500"><?php echo $d_count; ?></h3>
    </a>
    <a href="requests.php" class="bg-gray-800 p-4 rounded-2xl border-l-4 border-green-500">
        <p class="text-[10px] text-gray-500 font-bold uppercase">Pending Wit</p>
        <h3 class="text-2xl font-black text-green-500"><?php echo $w_count; ?></h3>
    </a>
</div>
<div class="mt-8">
    <a href="tournament.php" class="block w-full bg-red-600 py-4 rounded-2xl text-center font-bold shadow-lg uppercase">Create New Match</a>
</div>
<?php include 'common/bottom.php'; ?>