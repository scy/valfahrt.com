<?php

ini_set('display_errors', false);

require_once('class.phpmailer.php');

$post = false;
$errors = array();
$kommt = false;
$name = '';
$erwachsene = 1;
$kinder = 0;
$kontakt = '';
$text = '';

if (isset($_POST['kommt'])) {
	$post = true;
	$kommt = @$_POST['kommt'] == 'ja';
	$name = substr(@$_POST['name'], 0, 100);
	$erwachsene = (int)@$_POST['erwachsene'];
	$kinder = (int)@$_POST['kinder'];
	$kontakt = substr(@$_POST['kontakt'], 0, 100);
	$text = substr(@$_POST['text'], 0, 10240);
	if (empty($name))
		$errors[] = 'Du hast deinen Namen vergessen!';
	if (empty($kontakt) && $kommt)
		$errors[] = 'Du hast keine Kontaktmöglichkeit angegeben.';
	if (!count($errors)) {
		$mail = "
Hi,

$name hat gerade das Val-Formular ausgefüllt und kommt" . ($kommt ? '!' : ' nicht.');
		if ($kommt) {
			$mail .= "

   Anzahl Erwachsene: $erwachsene
   Anzahl Kinder:     $kinder
   Kontaktdaten:      $kontakt

$text";
		}
		$mail .= "

Beste Grüße

     deine dir auf ewig ergebene valfahrt.com.
";
		$mailer = new PHPMailer();
		$mailer->SetFrom('ichbindabei@valfahrt.com');
		$recs = array('ichbindabei valfahrt;com', 'naddie-val u5ma;de', 'scy-valfahrt scytale;name');
		foreach ($recs as $rec) {
			$mailer->AddAddress(strtr($rec, ' ;', '@.'));
		}
		$mailer->Subject = 'Neue Anmeldung auf valfahrt.com';
		$mailer->Body = $mail;
		$mailer->Mailer = 'smtp';
		if (!$mailer->Send()) {
			$errors[] = 'Es ist ein Fehler aufgetreten. Bitte versuche es erneut.';
		}
	}
}

include('header.php');

if ($post && !count($errors)) {
?>
<h2>Anmeldung abgeschickt</h2>
<p>
Vielen Dank für deine Anmeldung.
Wir werden uns schnellstmöglich mit dir in Verbindung setzen.
</p>
<p>
Solltest du in einigen Tagen noch nichts von uns gehört haben, bitten wir dich, nochmal nachzuhaken.
</p>
<?php
} else {
?>

<script>
var before = "";
$(function () {
	before = $("input:radio:checked[name=kommt]").val();
	if (before != "ja") {
		$(".hide").css("visibility", "hidden");
		$(".moveup").css("top", "-15em");
	}
	$("input[name=kommt]").click(function () {
		var now = $("input:radio:checked[name=kommt]").val();
		if (now == before) {
			return;
		}
		before = now;
		if (now == "ja") {
			$(".hide").fadeTo(0, 0);
			$(".hide").css("visibility", "visible");
			$(".moveup").animate({
				"top": "0em"
			}, 200, "swing", function () {
				$(".hide").fadeTo(500, 1);
			});
		} else {
			$(".hide").fadeTo(300, 0, function () {
				$(".hide").css("visibility", "hidden");
				$(".moveup").animate({
					"top": "-15em"
				}, 200);
			});
		}
	});
});
</script>
<h2>Anmeldeformular</h2>
<?php foreach ($errors as $error) { ?>
<p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php } ?>
<form action="anmeldung.php" method="POST"><table id="form">
<tr>
	<th>Kommst du?</th>
	<td>
		<input type="radio" name="kommt" value="nein" id="kommt-nein" <?php if (!$kommt) { echo 'checked="checked" '; } ?>/> <label for="kommt-nein">Nein, ich bleib’ lieber zuhause!</label><br />
		<input type="radio" name="kommt" value="ja" id="kommt-ja" <?php if ($kommt) { echo 'checked="checked" '; } ?>/> <label for="kommt-ja">Prima, ich fahr’ nach Val!</label>
	</td>
</tr><tr>
	<th><label for="name">Name:</label></th>
	<td><input type="text" name="name" id="name" maxlength="100" value="<?php echo htmlspecialchars($name); ?>" /></td>
</tr><tr class="hide">
	<th>Personen:</th>
	<td>
		<select name="erwachsene" id="erwachsene" size="1"><?php echo selectrange(1, 10, $erwachsene); ?></select> <label for="erwachsene">Erwachsene</label><br />
		<select name="kinder" id="kinder" size="1"><?php echo selectrange(0, 10, $kinder); ?></select> <label for="kinder">Kinder</label>
	</td>
</tr><tr class="hide">
	<th><label for="kontakt">E-Mail oder Telefon:</label></th>
	<td><input type="text" name="kontakt" id="kontakt" maxlength="100" value="<?php echo htmlspecialchars($kontakt); ?>"/></td>
</tr><tr class="hide">
	<th><label for="text">Anmerkungen / Ideen:</label></th>
	<td><textarea name="text" id="text" rows="5" cols="40"><?php echo htmlspecialchars($text); ?></textarea></td>
</tr><tr>
	<th></th>
	<td><input type="submit" value="Abschicken" class="moveup" /></td>
</tr>
</table></form>

<?php
}
include('footer.php');
?>
