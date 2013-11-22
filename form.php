<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
		<title>Todoist inbox</title>
		<link rel="stylesheet" href="css.css">
	</head>
	<body>
		<div class="wrapper">
			<!-- here will be response from server -->
			<div id="response"></div>

			<h2 id="title">Send to my Todoist inbox</h2>
			<form method="POST" id="todoist-form" autocomplete="off">
				<input type="text" name="inbox_item" value="" class="brilliant-idea" placeholder="Brilliant idea to capture" />
				<?php if( !empty( $inbox_password ) ) : ?>
				<input type="password" name="inbox_password" value="" placeholder="Inbox password" />
				<?php endif; ?>
				<input type="submit" name="send_inbox_item" value="Send to my Todoist" class="button" id="submit-button" />
			</form><!-- #todoist-form -->
			<div class="footer">Developed by <a href="http://hodak.pl/">hodak.pl</a></div>
		</div><!-- .wrapper -->
		<script src="js.js"></script>
	</body>
</html>
