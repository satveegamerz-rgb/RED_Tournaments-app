<?php
include '../common/config.php';
if(!isset($_SESSION['admin_id'])) header("Location: login.php");
$tid = $_GET['id'];
$t = $conn->query("SELECT * FROM tournaments WHERE id=$tid")->fetch_assoc();

if(isset($_POST['up_room'])){
    $rid = clean($_POST['rid']); $rp = clean($_POST['rpass']); $st = $_POST['status'];
    $conn->query("UPDATE tournaments SET room_id='$rid', room_password='$rp', status='$st' WHERE id=$tid");
    header("Location: manage_tournament.php?id=$tid");
}

if(isset($_POST['win'])){
    $uid = $_POST['winner_id'];
    $conn->query("UPDATE users SET wallet_balance = wallet_balance + {$t['prize_pool']} WHERE id=$uid");
    $conn->query("UPDATE tournaments SET status='Completed' WHERE id=$tid");
    $conn->query("INSERT INTO transactions (user_id, amount, type, description) VALUES ($uid, {$t['prize_pool']}, 'credit', 'WON Match: {$t['title']}')");
    header("Location: tournament.php");
}
include 'common/header.php';
?>
<h2 class="text-xl font-black mb-4 uppercase text-red-500"><?php echo $t['title']; ?></h2>

<form method="POST" class="bg-gray-800 p-4 rounded-2xl space-y-4 mb-8">
    <p class="text-[10px] text-gray-500 font-bold uppercase">Room Info</p>
    <input type="text" name="rid" value="<?php echo $t['room_id']; ?>" placeholder="Room ID" class="w-full bg-gray-700 p-3 rounded-xl outline-none">
    <input type="text" name="rpass" value="<?php echo $t['room_password']; ?>" placeholder="Room Password" class="w-full bg-gray-700 p-3 rounded-xl outline-none">
    <select name="status" class="w-full bg-gray-700 p-3 rounded-xl outline-none">
        <option value="Upcoming" <?php if($t['status']=='Upcoming') echo 'selected'; ?>>Upcoming</option>
        <option value="Live" <?php if($t['status']=='Live') echo 'selected'; ?>>Live</option>
        <option value="Completed" <?php if($t['status']=='Completed') echo 'selected'; ?>>Completed</option>
    </select>
    <button name="up_room" class="w-full bg-blue-600 py-3 rounded-xl font-bold uppercase">Update Room</button>
</form>

<form method="POST" class="bg-gray-800 p-4 rounded-2xl space-y-4">
    <p class="text-[10px] text-gray-500 font-bold uppercase">Declare Winner</p>
    <select name="winner_id" class="w-full bg-gray-700 p-3 rounded-xl outline-none">
        <?php
        $pl = $conn->query("SELECT u.id, u.username FROM participants p JOIN users u ON p.user_id=u.id WHERE p.tournament_id=$tid");
        while($p = $pl->fetch_assoc()) echo "<option value='{$p['id']}'>{$p['username']}</option>";
        ?>
    </select>
    <button name="win" onclick="return confirm('Confirm Winner?')" class="w-full bg-green-600 py-3 rounded-xl font-bold uppercase">Mark Winner & Pay</button>
</form>
<?php include 'common/bottom.php'; ?>
