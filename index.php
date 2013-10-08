<?php
/* author: http://hodak.pl/
 * -------------------------
 * You must fill in Your token and can fill in password if You want.
 * You can get Your token here:
			https://todoist.com/Users/viewPrefs?page=account 
 */
$todoist_token = '';
# Empty string disables password
$inbox_password = '';

/* ------- DON'T CHANGE CODE BELOW -------- */
define( 'TODOIST_API', 'http://todoist.com/API/' );

# show form when not handling post
if( !isset( $_POST['send_inbox_item'] ) ) {
	include_once( 'form.php' );
	exit;
}

# no content
if( !isset( $_POST['inbox_item'] ) || empty( $_POST['inbox_item'] ) ) {
	echo 'No content, try again';
	exit;
}
# wrong password
if( $inbox_password != '' && $inbox_password != $_POST['inbox_password'] ) {
	echo 'Wrong password, try again.';
	exit;
}

$content = urlencode( $_POST['inbox_item'] );

# get the ID of inbox_projects. I'm not sure it's always first in line so we must search it.
$projects = json_decode( file_get_contents( TODOIST_API . "getProjects?token={$todoist_token}" ) );
if( !is_array( $projects ) ) {
	echo "<br />Couldn't get projects, please check Your API Key: <a href=\"https://todoist.com/Users/viewPrefs?page=account\">https://todoist.com/Users/viewPrefs?page=account</a><br />";
	exit;
}
$inbox_id = -1;
foreach( $projects as $project ) {
	if( true == $project -> inbox_project ) {
		$inbox_id = $project -> id;
		break;
	}
}
# inbox_project not found. probably should not happen but it did, tough love.
# contact me at hodak@hodak.pl if it happened to You
if( -1 === $inbox_id ) {
	echo "Inbox project not found";
	exit;
}

# core of the project
$send_inbox_item = file_get_contents( TODOIST_API . "addItem?token={$todoist_token}&content={$content}&project_id={$inbox_id}&priority=1" );

# i'm an optimist and I believe it also should never happen
if( '"ERROR_PROJECT_NOT_FOUND"' === $send_inbox_item || '"ERROR_WRONG_DATE_SYNTAX"' === $send_inbox_item ) {
	echo "Couldn't send item to inbox";
	exit;
} else {
	echo "Successfully sent item to Your inbox";
	exit;
}

//header( 'Location: index.php' );
?>
