<?php
$uri = sso()['base_uri'] . sso()['authorize']['endpoint'];
$grant_type = sso()['authorize']['grant_type'];
$response_type = sso()['authorize']['response_type'];
$client_id = sso()['authorize']['client_id'];
$scope = sso()['authorize']['scope'];
$nonce = sso()['authorize']['nonce'];
$state = sso()['authorize']['state'];
$redirect_uri = sso()['authorize']['redirect_uri'];
$authorize_url = $uri . '?grant_type=' . $grant_type . '&response_type=' . $response_type . '&client_id=' . $client_id . '&scope=' . $scope . '&nonce=' . $nonce . 'state=' . $state . '&redirect_uri=' . $redirect_uri;
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<title>Mutasi</title>
	<link rel="shortcut icon" href="<?= base_url(); ?>assets/img/mutasi.png" type=" image/x-icon">
	<link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}
	</style>


</head>

<body>

	<main>
		<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center">
			<div class="col-md-6 p-lg-5 mx-auto my-5">
				<h1 class="display-4 font-weight-normal">Hai!, Selamat Datang di Sistem Perhitungan Biaya Mutasi.</h1>
				<p class="font-weight-light mt-4">Dengan Sistem Perhitungan Biaya Mutasi, kami hadirkan kemudahan dalam mengakses informasi biaya mutasi di layar Anda.</p>
				<a class="btn btn-outline-primary mb-3" href="<?= $authorize_url; ?>">Login Menggunakan Kemenkeu ID</a>
			</div>
		</div>
	</main>

	<script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>

</body>

</html>