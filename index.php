<?php
// include views and controllers
require_once('constants.php');
require_once('view/AddView.php');
require_once('view/MainMenuView.php');
require_once('view/ErrorView.php');

// figure out which menu to display and display it
//	also figure out the correct controller if applicable
$view;
$controller;
$viewOutput = "";

// display the correct page
if (!empty($_GET[$PAGE_GET_VAR])) {
	// get page URL if it exists
	$page = $_GET[$PAGE_GET_VAR];

	if ($page == $PAGE_GET_NAME_ADD) {
		// set correct view
		$view = new AddView();
		
	} elseif ($page == $PAGE_GET_NAME_REVIEW) {
		// display review card prompt
	} else {
		// set the error class as the view
		$view = new ErrorView();
	}
} else {
	// set the main menu as the view
	$view = new MainMenuView();
}

// set the view output
$viewOutput = $view->output();

// set the page title
$pageTitle = $APP_TITLE . " - " . $view->title;

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta charset="UTF-8">
		<title><?php echo $pageTitle; ?></title>
	</head>
	<body>
		<?php echo $viewOutput; ?>
	</body>
</html>