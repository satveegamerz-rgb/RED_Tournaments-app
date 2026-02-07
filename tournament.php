<?php
include '../common/config.php';
if(!isset($_SESSION['admin_id'])) header("Location: login.php");

if(isset($_POST['add'])){
    $t = clean($_POST['title']); $g = clean($_POST['game']); $f = clean($_POST['fee']); $p = clean($_POST['prize']); $tm = clean($_POST['time']);
    $conn->query("INSERT INTO tournaments (title, game_name, entry_fee, prize_pool, match_time) VALUES ('$t', '$g', '$f', '$p', '$tm')");
}
if(isset($_GET['del'])){ $id=$_GET['del']; $conn->query("DELETE FROM tournaments WHERE id=$id"); }

include 'common/header.php';
?>
<h2 class="text-xl font-bold mb-4 italic">CREATE MATCH</h2>
<form method="POST" class="bg-gray-800 p-4 rounded-2xl space-y-3 mb-8">
    <input type="text" name="title" placeholder="Match Title" class="w-full bg-gray-700 p-3 rounded-xl outline-none" required>
    <input type="text" name="game" placeholder="Game (e.g. Free Fire)" class="w-full bg-gray-700 p-3 rounded-xl outline-none" required>
    <div class="flex gap-2">
        <input type="number" name="fee" placeholder="Entry Fee" class="w-full bg-gray-700 p-3 rounded-xl outline-none" required>
        <input type="number" name="prize" placeholder="Prize Pool" class="w-full bg-gray-700 p-3 rounded-xl outline-none" required>
    </div>
    <input type="datetime-local" name="time" class="w-full bg-gray-700 p-3 rounded-xl outline-none" required>
    <button name="add" class="w-full bg-blue-600 py-3 rounded-xl font-bold uppercase">Save Match</button>
</form>

<h2 class="text-xl font-bold mb-4 italic">ALL MATCHES</h2>
<div class="space-y-3">
<?php
$res = $conn->query("SELECT * FROM tournaments ORDER BY id DESC");
while($row = $res->fetch_assoc()): ?>
<div class="bg-gray-800 p-4 rounded-xl flex justify-between items-center border border-gray-700">
    <div><p class="font-bold text-sm"><?php echo $row['title']; ?></p><p class="text-[10px] text-gray-500"><?php echo $row['status']; ?></p></div>
    <div class="flex gap-2">
        <a href="manage_tournament.php?id=<?php echo $row['id']; ?>" class="bg-green-600 px-3 py-1 rounded text-xs">Manage</a>
        <a href="?del=<?php echo $row['id']; ?>" class="bg-red-600 px-3 py-1 rounded text-xs"><i class="fas fa-trash"></i></a>
    </div>
</div>
<?php endwhile; ?>
</div>
<?php include 'common/bottom.php'; ?>