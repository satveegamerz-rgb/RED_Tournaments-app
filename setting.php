<?php
include '../common/config.php';
if(!isset($_SESSION['admin_id'])) header("Location: login.php");

if(isset($_POST['save'])){
    $upi = clean($_POST['upi']);
    if(!empty($_FILES["qr"]["name"])) {
        $path = "../uploads/qr.png";
        move_uploaded_file($_FILES["qr"]["tmp_name"], $path);
        $conn->query("UPDATE settings SET admin_upi_id='$upi', qr_code_path='uploads/qr.png' WHERE id=1");
    } else {
        $conn->query("UPDATE settings SET admin_upi_id='$upi' WHERE id=1");
    }
}
$s = $conn->query("SELECT * FROM settings WHERE id=1")->fetch_assoc();
include 'common/header.php';
?>
<h2 class="text-xl font-bold mb-6 italic uppercase">Payment Settings</h2>
<form method="POST" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-3xl space-y-4">
    <div>
        <label class="text-[10px] font-bold text-gray-500 uppercase">Admin UPI ID</label>
        <input type="text" name="upi" value="<?php echo $s['admin_upi_id']; ?>" class="w-full bg-gray-700 p-3 rounded-xl outline-none mt-1">
    </div>
    <div>
        <label class="text-[10px] font-bold text-gray-500 uppercase">Upload New QR Code</label>
        <input type="file" name="qr" class="w-full bg-gray-700 p-3 rounded-xl outline-none mt-1 text-xs">
    </div>
    <button name="save" class="w-full bg-red-600 py-3 rounded-xl font-bold uppercase shadow-lg shadow-red-600/20">Save Changes</button>
</form>
<?php include 'common/bottom.php'; ?>