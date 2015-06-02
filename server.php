<?php

require_once "layout/header.php";
require_once "request.php";

$request = new Request();
$sock = $request->createSocket();
$info = $request->getInfo();
$request->disconnect();
?>

<section class="wrapper scrollable">
	<?php require_once "layout/menubar.php"; ?>
	<br>
	<div class="col-md-3">
		<div class="panel panel-default panel-block">
			<div class="list-group">
				<div class="list-group-item">
					<h4 class="section-title">Search Clients</h4>
					<form class="form-horizontal" name="search" method="post">

						<div class="form-group">
							<div class="col-lg-12">
								<select class="form-control" name="what">
									<option value="country">Country</option>
									<option value="userstring">Username</option>
									<option value="os">Operating System</option>
									<option value="ip">IP</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-12">
								<input name="keyword" id="input-horizontal"
									class="form-control input-counter" placeholder="Keyword">
							</div>
						</div>


						<div class="form-group">
							<label for="input-horizontal" class="col-lg-4 control-label"></label>
							<div class="col-lg-8" align="right">
								<button type="button" class="btn btn-primary"
									onclick="javascript:document.search.submit();">Search</button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<?php

require_once "layout/footer.php";

?>