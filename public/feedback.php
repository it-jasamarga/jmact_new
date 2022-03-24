<?php

$DATA = [
	'DB_SERVER'		=> "127.0.0.1",
	'DB_NAME'		=> "jm_act",
	'DB_USERNAME'	=> "admin",
	'DB_PASSWORD'	=> "Mysql@123"
];

$local = (PHP_OS == 'WINNT') ? "id-ID" : "id_ID";

// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// mysqli_report(MYSQLI_REPORT_ALL & ~MYSQLI_REPORT_INDEX);
mysqli_report(MYSQLI_REPORT_OFF);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

	$kepuasan = [ 5 => "Sangat Puas", 4 => "Puas", 3 => "Cukup Puas", 2 => "Tidak Puas", 1 => "Sangat Tidak Puas" ];
	$ketidakpuasan = [];

	if (! preg_match('/([CK])([a-z0-9]+):([a-z0-9]+)/i', $_SERVER['QUERY_STRING'], $matches)) {
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
		echo '<div style="width:600px;margin: auto"><h1>404 Not Found</h1>';
		echo '<p>Mohon maaf nomor tiket tidak ditemukan, periksa kembali link Anda.</p></div>';
		exit;
	} else {
		$IS_KELUHAN = strtoupper($matches[1]) == "K";
		$DATA['no_tiket'] = $matches[1].$matches[2];
		$DATA['token'] = $matches[3];
	}

	// TODO: token verification
	$pair = substr(strtoupper(MD5($DATA["no_tiket"])), -4);
	$auth = ($DATA['token'] == $pair);

	// echo "<pre>";
	// var_dump($DATA, $pair);
	// exit;

	$conn = new mysqli($DATA['DB_SERVER'], $DATA['DB_USERNAME'], $DATA['DB_PASSWORD'], $DATA['DB_NAME']);

	if ($conn->connect_error) {
		header($_SERVER["SERVER_PROTOCOL"]." 503 Service Temporarily Unavailable", true, 503);
		echo '<div style="width:600px;margin: auto"><h1>503 Service Temporarily Unavailable</h1>';
		echo '<p>Mohon maaf untuk saat ini layanan database tidak dapat diakses.</p></div>';
		exit;
	}

	if (! $auth) {
		$sql = "SELECT no_telepon FROM ". ($IS_KELUHAN ? "keluhan" : "claim") ." WHERE no_tiket=\"".$DATA['no_tiket']."\";";
		$qry = $conn->query($sql);
		if ($qry->num_rows > 0) {
			$row = $qry->fetch_assoc();
			if (! is_null($row['no_telepon'])) {
				if (preg_match("/[0-9]+([0-9]{4})/", $row['no_telepon'], $matches)) {
					if (strlen($matches[1]) == 4) {
						$auth = ($DATA['token'] == $matches[1]);
					}
				}
			}
		}
	}

	if (! $auth) {
		header($_SERVER["SERVER_PROTOCOL"]." 401 Unauthorized", true, 401);
		echo '<div style="width:600px;margin: auto"><h1>401 Unauthorized</h1>';
		echo '<p>Mohon maaf nomor tiket tidak dapat diakses, periksa kembali link Anda.</p></div>';
		exit;
	}

	$sql = 'SELECT created_at FROM detail_history WHERE status_id IN (SELECT id FROM master_status WHERE status LIKE "%Feedback%" OR status LIKE "%Konfirmasi%" OR status LIKE "%Pembayaran%") AND '.($IS_KELUHAN ? "keluhan" : "claim").'_id IN (SELECT id FROM '.($IS_KELUHAN ? "keluhan" : "claim").' WHERE no_tiket="'.$DATA['no_tiket'].'")';
	$qry = $conn->query($sql);
	if ($qry->num_rows > 0) {
		$row = $qry->fetch_assoc();
		setlocale (LC_TIME, $local);
		$DATA['SOLVED'] = strftime("hari %A, tanggal %e %B %Y", strtotime($row['created_at']));
		// $DATA['SOLVED'] = strftime("hari %A, tanggal %e %B %Y jam %R", strtotime($row['created_at']));
	}
	// echo "<pre>";
	// var_dump($sql);
	// exit;

	$sql = "SELECT * FROM feedback WHERE no_tiket=\"".$DATA['no_tiket']."\";";
	$qry = $conn->query($sql);
	if ($qry->num_rows > 0) {
		$row = $qry->fetch_assoc();
		$DATA['NEW'] = false;
		$DATA['EXIST'] = true;
		$DATA['FEEDBACK'] = $row['created_at'];
		setlocale (LC_TIME, $local);
		$DATA['FEEDBACK'] = strftime("hari %A, tanggal %e %B %Y jam %R", strtotime($row['created_at']));
	}

	$sql = "SELECT ketidakpuasan FROM feedback_unsatisfactions;";
	$qry = $conn->query($sql);
	while($row = $qry->fetch_assoc()) { $ketidakpuasan[] = $row["ketidakpuasan"]; }

	$DATA['SQL'] = $IS_KELUHAN ?
		"SELECT K.no_tiket, K.no_telepon, K.sosial_media, B.keluhan as bidang, K.keterangan_keluhan AS keterangan FROM keluhan K LEFT JOIN master_bk B ON B.id = K.bidang_id WHERE no_tiket='".$DATA['no_tiket']."';"
		:
		"SELECT C.no_tiket, C.no_telepon, C.sosial_media, J.jenis_claim AS bidang, c.keterangan_claim AS keterangan FROM claim C LEFT JOIN master_jenis_claim J ON J.id = C.jenis_claim_id WHERE no_tiket='".$DATA['no_tiket']."';";
	$DATA['QUERY'] = $conn->query($DATA['SQL']);

	if ($DATA['QUERY']->num_rows != 1) {
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
		echo '<div style="width:600px;margin: auto"><h1>404 Not Found</h1>';
		echo '<p>Mohon maaf nomor tiket tidak ditemukan, periksa kembali link Anda.</p></div>';
		exit;
	}

	$DATA['RECORD'] = $DATA['QUERY']->fetch_assoc();

	$conn->close();

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// TODO: token verification

	$conn = new mysqli($DATA['DB_SERVER'], $DATA['DB_USERNAME'], $DATA['DB_PASSWORD'], $DATA['DB_NAME']);

	if ($conn->connect_error) {
		header($_SERVER["SERVER_PROTOCOL"]." 503 Service Temporarily Unavailable", true, 503);
		echo '<div style="width:600px;margin: auto"><h1>503 Service Temporarily Unavailable</h1>';
		echo '<p>Mohon maaf untuk saat ini layanan database tidak dapat diakses.</p></div>';
		exit;
	}

	$IS_KELUHAN = strtoupper($_POST['no_tiket'][0]) == "K";

	$sql = "SELECT created_at FROM feedback WHERE no_tiket=\"".$_POST['no_tiket']."\";";
	$qry = $conn->query($sql);

	$DATA = [];

	if ($qry->num_rows > 0) {
		$row = $qry->fetch_assoc();
		$DATA['NEW'] = false;
		$DATA['EXIST'] = true;
		$DATA['FEEDBACK'] = $row['created_at'];
	} else {
		$DATA['NEW'] = true;
		$DATA['EXIST'] = false;
		$DATA['POSTED'] = $_POST;
		$DATA['POSTED']['ketidakpuasan'] = json_encode($_POST['ketidakpuasan']);
		$DATA['POSTED']['attribute'] = json_encode(['ip_address' => $_SERVER['REMOTE_ADDR']]);
		$DATA['SQL'] = "INSERT INTO feedback (no_tiket, no_telepon_sosial_media, rating, ketidakpuasan, saran_masukan, attribute, created_at) VALUES (";
		$DATA['SQL'] .= "\"".mysqli_real_escape_string($conn, $DATA['POSTED']['no_tiket'])."\", ";
		$DATA['SQL'] .= "\"".mysqli_real_escape_string($conn, $DATA['POSTED']['no_telepon_sosial_media'])."\", ";
		$DATA['SQL'] .= $DATA['POSTED']['rating'].", ";
		$DATA['SQL'] .= "\"".mysqli_real_escape_string($conn, $DATA['POSTED']['ketidakpuasan'])."\", ";
		$DATA['SQL'] .= "\"".mysqli_real_escape_string($conn, $DATA['POSTED']['saran_masukan'])."\", ";
		$DATA['SQL'] .= "\"".mysqli_real_escape_string($conn, $DATA['POSTED']['attribute'])."\", ";
		$DATA['SQL'] .= "now()";
		$DATA['SQL'] .= ");";

		$DATA['RESULT'] = false;
		if ($stmt = $conn->prepare($DATA['SQL'])) {
			$stmt->execute();
			$DATA['RESULT'] = ($stmt->affected_rows == 1);
		}

		if ($DATA['RESULT']) {
			$sql = 'SELECT id FROM '.($IS_KELUHAN ? "keluhan" : "claim").' WHERE no_tiket="'.$DATA['POSTED']['no_tiket'].'";';
			$qry = $conn->query($sql);
			$id = 0;
			if ($qry->num_rows > 0) { $row = $qry->fetch_assoc(); $id = $row['id']; }
			if ($id > 0) {
				$sql = 'SELECT id FROM master_status WHERE type='.($IS_KELUHAN ? 1 : 2).' AND status="Closed" LIMIT 1';
				$qry = $conn->query($sql);
				$status_id = 0;
				if ($qry->num_rows > 0) { $row = $qry->fetch_assoc(); $status_id = $row['id']; }
				if ($status_id > 0) {
					$sql = 'UPDATE '.($IS_KELUHAN ? "keluhan" : "claim").' SET status_id='.$status_id.' WHERE no_tiket="'.$DATA['POSTED']['no_tiket'].'";';
					if ($stmt = $conn->prepare($sql)) $stmt->execute();
					$sql = 'INSERT INTO detail_history ('.($IS_KELUHAN ? "keluhan" : "claim").'_id, status_id, created_at, updated_at) VALUES ('.$id.', '.$status_id.', now(), now());';
					if ($stmt = $conn->prepare($sql)) $stmt->execute();
				}
			}
		}

		// echo "<pre>";
		// var_dump($DATA);

		$sql = "SELECT * FROM feedback WHERE no_tiket=\"".$_POST['no_tiket']."\";";
		$qry = $conn->query($sql);
		if ($qry->num_rows > 0) {
			$row = $qry->fetch_assoc();
			$DATA['EXIST'] = true;
			$DATA['FEEDBACK'] = $row['created_at'];
		}

	}

	if (isset($DATA['FEEDBACK'])) {
		$local = (PHP_OS == 'WINNT') ? "id-ID" : "id_ID";
		setlocale (LC_TIME, $local);
		$DATA['FEEDBACK'] = strftime("hari %A, tanggal %e %B %Y jam %R", strtotime($DATA['FEEDBACK']));
	}

	$DATA['no_tiket'] = $_POST['no_tiket'];

	$conn->close();

} else {

	header($_SERVER["SERVER_PROTOCOL"]." 501 Not Implemented", true, 501);
	echo '<div style="width:600px;margin: auto"><h1>501 Not Implemented</h1>';
	echo '<p>Request Method unsupported.</p></div>';
	exit;

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Jasa Marga Feedback Form</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap">
	<style>
*, body, html {
	font-family: 'Roboto', sans-serif;
	font-size: 0.98em;
	background-color: #f1f1f1;
}
.centered {
	margin-left: auto;
	margin-right: auto;
}
.rounded {
	border: 1px solid #ddd;
	border-radius: 5px;
}
#header {
	width: 600px;
	height: 148px;
	background: #fff url('image/feedback-header.jpg') no-repeat;
	background-size: 100%;
	margin-top: 3px;
	margin-bottom: 8px;
}
.content {
	width: 560px;
	border: 1px solid #ddd;
	border-top: 5px solid #009;
	background-color: #fff;
	padding: 20px;
	margin-bottom: 8px;
}
.content * { background-color: #fff; }
.highlight { font-weight: bold; color: #000066; }
.informative { font-weight: bold; color: #000066; }
input {
	margin-top: 5px;
	border: 1px solid #aaa;
	border-radius: 1px;
	padding: 5px 8px;
	background-color: #fff;
}
input:focus { outline: none; border: 1px solid #99a; }
input[type="text"] {
	width: 540px;
}
input[type="submit"] {
	color: #fff;
	background-color: #006!important;
	border-radius: 5px;
	cursor: pointer;
}
input[type="checkbox"] {
	margin: 5px 15px 5px 0;
}
/* input:not([name]) {
	margin: 15px 15px 15px 0;
} */
input[type="radio"] {
	margin: 5px 15px 5px 0;
}
	</style>
</head>
<body>
	<div id="header" class="centered rounded"></div>

	<div class="content centered rounded">
<?php if (($_SERVER['REQUEST_METHOD'] === 'GET') && (! isset($DATA['FEEDBACK']))) { ?>
		Salam pelanggan jalan tol Jasa Marga Group yang terhormat,
		<p>Anda telah terdaftar di sistem kami sebagai pelanggan yang menggunakan fasilitas pelayanan jalan tol dari petugas Jasa Marga. informasi dan masukan yang anda berikan sangat berarti untuk perbaikan pelayanan kami ke depannya.</p>
		<p class="highlight"><?= $IS_KELUHAN ? "Keluhan" : "Claim" ?> Anda sudah diselesaikan pada <?= $DATA['SOLVED']; ?></p>
		<p>Nomor Tiket <span class="informative"><?= $DATA['RECORD']['no_tiket'] ?></span></p>
		<p><?= $IS_KELUHAN ? "Keluhan" : "Jenis Claim" ?>: <span class="informative"><?= $DATA['RECORD']['bidang'] ?></span></p>
		<p>Keterangan:<br><span class="informative"><?= $DATA['RECORD']['keterangan'] ?></span></p>
<?php } else if (($_SERVER['REQUEST_METHOD'] === 'POST') || (isset($DATA['FEEDBACK']))) {

if (($DATA['NEW']) && ($DATA['EXIST'])) echo "Feedback Anda dengan nomor tiket <b>".$DATA['no_tiket']."</b> telah berhasil tersimpan dalam database kami.";
if ((! $DATA['NEW']) && ($DATA['EXIST'])) echo "Mohon maaf, feedback Anda dengan nomor tiket <b>".$DATA['no_tiket']."</b> telah tersimpan sebelumnya pada ".$DATA['FEEDBACK'].".";
if ((! $DATA['NEW']) && (! $DATA['EXIST'])) echo "Mohon maaf, feedback Anda dengan nomor tiket <b>".$DATA['no_tiket']."</b> tidak berhasil disimpan ke dalam database kami, silakan dicoba kembali.";

?>

		<p>Terima kasih telah menyempatkan waktu anda untuk mengisi kuesioner ini.</p>
		<p>Apabila terdapat kendala pada pelayanan kami, silahkan hubungi kami melalui One Call Center 14080 atau dapat melalui Twitter @PTJASAMARGA.</p>
		<p>Salam sehat selalu,</p>
		<p>Customer Care Jasa Marga</p>
<?php } ?>
	</div>
<?php if (($_SERVER['REQUEST_METHOD'] === 'GET') && (! isset($DATA['FEEDBACK']))) { ?>
	<form method="POST">
	<input type="hidden" name="no_tiket" value="<?= $DATA['RECORD']['no_tiket'] ?>">
	<input type="hidden" name="token" value="<?= $DATA['token'] ?>">
	<div class="content centered rounded">
		No Telepon/Sosial Media :<br><input type="text" name="no_telepon_sosial_media" autocomplete="off" required value="<?= $DATA['RECORD']['no_telepon']."/".$DATA['RECORD']['sosial_media'] ?>">
		<p>Dari skala 1-5, berapa rating yang anda berikan terhadap layanan dari petugas kami di lapangan?<br>
<?php
	for ($i=5; $i>0;$i--) {
		echo '<input type="radio" required name="rating" value="'.$i.'"><span>';
		for ($j=1; $j<=$i; $j++) { echo "&#9733;"; };
		for ($j=$i; $j<5; $j++) { echo "&#9734;"; };
		echo ' '.$kepuasan[$i].'</span><br>';
	}
?>
		</p>
		<p style="margin-top: 10px">Jika anda merasa kurang puas, hal apa yang membuat anda kurang puas (dapat memilih lebih dari satu)?<br>
<?php
	foreach ($ketidakpuasan as $item) {
		echo '<input type="checkbox" name="ketidakpuasan[]" value="'.$item.'">'.$item.'<br>';
	}
?>
			<input onclick="theother(this)" type="checkbox">lainnya<span id="other-wrapper" style="display: none"> : <input id="other-input" type="text" name="ketidakpuasan[]" autocomplete="off"></span>
		</p>
		<p>Saran dan Masukan :<br><input type="text" name="saran_masukan" autocomplete="off" required style="min-width: 500px"></p>
		<p><input type="submit" value="Submit"></p>
	</div>
	</form>
<?php } ?>
<script>
	let theother = function(other) {
		let wrapper = document.getElementById('other-wrapper');
		let input = document.getElementById('other-input');
		if (other.checked) {
			wrapper.style.display = '';
			input.setAttribute("required", "required");
		} else {
			wrapper.style.display = 'none';
			input.removeAttribute("required");
		}
	}
</script>
</body>
</html>