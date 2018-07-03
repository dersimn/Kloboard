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
	$query = "SET NAMES 'utf8'";
	$result = mysqli_query($db, $query);
	if ($result) {
		// Success
		//echo "Set to UTF-8 <br>";
	} else {
		// Failure
		echo "Set UTF-8 query failed. " . mysqli_error($db) . "<br>";
	}
?>
<?php
	// 2. Perform database query
	$query  = "SELECT * ";
	$query .= "FROM klos ";
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
	</head>
	<body>
		
		<ul>
		<?php
			// 3. Use returned data (if any)
			while($klo = mysqli_fetch_assoc($result)) {
				// output data from each row
		?>
				<li>
					<a href="klo.php?hash=<?php echo urlencode($klo["hash"]); ?>">
						<?php echo $klo["description"]; ?>
					</a>
				</li>
	  <?php
			}
		?>
		</ul>
		
		<?php
		  // 4. Release returned data
		  mysqli_free_result($result);
		?>
	</body>
</html>

<?php
  // 5. Close database connection
  mysqli_close($db);
?>