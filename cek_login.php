<?php
	session_start();
	if (! isset($_SESSION['login'])) {
		echo "<meta http-equiv='refresh' content='0;url=index.php'>";
	}
?>