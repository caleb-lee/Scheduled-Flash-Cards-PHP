<?php
// include views and controllers
require_once('constants.php');
require_once('view/AddView.php');

// figure out which menu to display and display it
//	also figure out the correct controller if applicable
$view;
$controller;
$viewOutput = "";

// get the page from the URL
$page = $_GET[$PAGE_GET_VAR];

// display the correct page
if (!empty($page)) {
	if ($page == $PAGE_GET_NAME_ADD) {
		// set correct view
		$view = new AddView();
		
	} elseif ($page == $PAGE_GET_NAME_REVIEW) {
		// display review card prompt
	} else {
		// display error
	}
} else {
	// display the main menu
}

$viewOutput = $view->output();

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta charset="UTF-8">
		<title><?php echo $PAGE_TITLE; ?></title>
	</head>
	<body>
		<?php echo $viewOutput; ?>
	</body>
</html>