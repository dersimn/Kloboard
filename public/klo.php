<?php
	include("../private/Parsedown.php");
	$Parsedown = new Parsedown();
?>
<?php
	// 1. Create a database connection
	$dbhost = "mysql";
	$dbuser = "kloboard";
	$dbpass = "kloboard";
	$dbname = "kloboard";
	$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	// Test if connection succeeded
	if(mysqli_connect_errno()) {
		die("Database connection failed: " . 
			mysqli_connect_error() . 
			" (" . mysqli_connect_errno() . ")"
		);
	}

	// Set Conenction char set to UTF-8
	$query = "SET NAMES 'utf8mb4'";
	$result = mysqli_query($db, $query);
	if ($result) {
		// Success
		//echo "Set to UTF-8 <br>";
	} else {
		// Failure
		die("Set UTF-8 query failed. " . mysqli_error($db) . "<br>");
	}
?>
<?php
	// Check if this was a POST request
	if (isset($_POST['submit'])) {
		// form was submitted
		$message = mysqli_real_escape_string($db, $_POST["message"]);
		//echo $message;
		$hash = $_POST["hash"];
		$ip = mysqli_real_escape_string($db, $_SERVER['REMOTE_ADDR']);

		// 2. Perform database query
		$query  = "INSERT INTO `comments` (";
		$query .= "  klo_hash, message, ip";
		$query .= ") VALUES (";
		$query .= "  '{$hash}', '{$message}', '{$ip}'";
		$query .= ")";

		$result = mysqli_query($db, $query);

		if ($result) {
			// Success
			//TODO: Workaround: Redirect via GET request, prevents double-send on refresh
			header("Location: /stuhlgangscode/" . $hash);
			exit;
		} else {
			// Failure
			die("Database query failed. " . mysqli_error($db) . " " . $query);
		}
	}
?>
<?php
	if (isset($_GET['hash'])) {
		// form was submitted
		$hash = $_GET['hash'];
	} else {
		$hash = 0;
	}

	// 2. Perform database query
	$query  = "SELECT * FROM `comments` ";
	$query .= "WHERE `klo_hash` = '" . mysqli_real_escape_string($db, $hash) . "' ";
	$query .= "ORDER BY created ASC";
	$result = mysqli_query($db, $query);
	// Test if there was a query error
	if (!$result) {
		die("Database query failed.");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="/ressources/autogrow.min.js"></script>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
	<script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
	<script type="text/x-mathjax-config">
		MathJax.Hub.Config({
			tex2jax: {
				inlineMath: [ ['$','$'], ["\\(","\\)"] ],
				displayMath: [  ],
				processEscapes: true
			}
		});
	</script>
	
	<style>
		body {
			padding-top: 71px;
			padding-bottom: 53px;
		}
		.message-form {
			display: flex;
			width: 100%;
		}
		@media (max-width: 768px) {
			.message-form {
				margin: 0;
			}
		}
		.message-input {
			flex-grow: 1;
			margin-right: 10px;
		}
		.bubble {
			background-color: #ededed;
			margin-bottom: 20px;
			padding: 20px;
			border-radius: 20px;
			text-align: justify;
			position: relative;
		}
		.bubble-info {
			color: #b0b0b0;
			position: absolute;
			top: 0px;
			right: 20px;
		}
		.bubble-message p {
			margin-bottom: 0;
		}
	</style>
	
	<script>
		$(function(){
			$(".message-form > textarea").autogrow({
				animate: false
			});	

			$('html, body').animate({ 
				scrollTop: $(document).height()-$(window).height()}, 
				500, 
				"swing"
			);
		});
	</script>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">💩 KloBoard 💩</a>
			</div>
		</div>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php while($comment = mysqli_fetch_assoc($result)) { ?>
				<div class="bubble">
					<div class="bubble-info"><?= $comment['created'] ?></div>
					<div class="bubble-message"><?= $Parsedown->text( $comment['message'] ); ?></div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	
	<nav class="navbar navbar-default navbar-fixed-bottom">
		<form class="navbar-form message-form" action="/klo.php" method="post">
			<input type="hidden" name="hash" value="<?= $hash ?>">
			<textarea class="form-control message-input" rows="1" name="message" placeholder="Message"></textarea>
			<button type="submit" name="submit" class="btn btn-default">Send</button>
		</form>
	</nav>
</body>
</html>

<?php
	// 5. Close database connection
	mysqli_close($db);
?>