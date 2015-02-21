<?php
// include views and controllers
include_once('view/AddView.php');

// set the page title
$PAGE_TITLE = "Spaced Repetition Flash Card System";
$PAGE_GET_NAME_ADD = "add";
$PAGE_GET_NAME_REVIEW = "review";

// figure out which menu to display and display it
//	also figure out the correct controller if applicable
$view;
$controller;
$viewOutput = "";

// get the page from the URL
$page = $_GET['page'];

// display the correct page
if (!empty($page)) {
	if ($page == $PAGE_GET_NAME_ADD) {
		// set correct view
		$view = new AddView();
		
	} elseif ($page == $PAGE_GET_NAME_REVIEW) {
		// display review card prompt
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