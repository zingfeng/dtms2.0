<form method="POST" action="">
	<input type="text" name="article_id" required>
	<button type="submit">Convert</button>
</form>
<?php if ($result) {
	echo '<p>Convert OK</p>';
}