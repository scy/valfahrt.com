<?php echo '<' . '?xml version="1.0" encoding="UTF-8" ?' . '>'; ?>
<!DOCTYPE html>
<?php
function selectrange($min, $max, $val) {
	for ($i = $min; $i <= $max; $i++) {
		$checked = ($val == $i) ? ' selected="selected"' : '';
		echo "<option value=\"$i\"$checked>$i</option>";
	}
}
?>
<html lang="de" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8" />
	<title>VAL – next generation</title>
	<link rel="stylesheet" href="valfahrt.css" />
	<script src="jquery-1.4.2.min.js"></script>
</head>
<body>
<div id="header">
	<a id="logo" href="index.php">
		<h1>Val – next generation</h1>
	</a>
</div>
<div id="subtitle">
<table><tr>
	<td class="l">Val Sainte Marie</td>
	<td class="r">9. – 16. Oktober 2010</td>
</tr></table>
</div>
<div id="content">
