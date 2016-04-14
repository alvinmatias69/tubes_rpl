<!DOCTYPE html>
<html>
<head>
	<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$extension = basename($_POST['dir']);
		    header("Cache-Control: public");
		    header("Content-Description: File Transfer");
		    header("Content-Disposition: attachment; filename=$extension");
		    header("Content-Type: pdf/pptx/docx");
		    header("Content-Transfer-Encoding: binary");

		    // read the file from disk
		    readfile($_POST['dir']);
		    echo $_POST['dir'];
		    echo $_POST['source'];
		    echo "<meta http-equiv='refresh' content='0;url='" . $_POST['source'] . "'>";
		}
	?>
</head>
<body>

</body>
</html>