<?php

	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	define("BASE_PATH", __DIR__ . "/");

	require_once BASE_PATH . "config/config.php";
	require_once BASE_PATH . "config/connect.php";
	require_once BASE_PATH . "controller/baseController.php";

	$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$uri = explode( '/', $uri );

	$db = new Database();

	$baseController = new BaseController();
	$baseController->checkApiRequests();

	if(isset($uri[3]) AND isset($uri[4])) {
		if(file_exists(BASE_PATH . "/controller/" . $uri[3] . "Controller.php")) {
			require BASE_PATH . "/controller/" . $uri[3] . "Controller.php";
			$controllerName = $uri[3] . "Controller";
			$objController = new $controllerName;
			$methodName = $uri[4];
			$objController->{$methodName}();
		}
		else {
			$baseController->invalidRequest();
		}
	}
	else {
		?>
		<!DOCTYPE html>
			<html>
				<head>
					<meta charset="utf-8">
					<meta name="viewport" content="width=device-width, initial-scale=1">
					<title></title>
					<script type="text/javascript">
						
						function makeApiRequests() {
							const url = '<?php echo $_SERVER['PHP_SELF'] ?>';

							// Set the number of api calls per second
							const requestsPerSecond = document.getElementById("api_request").value;

							// Set the interval between api calls in milliseconds
							const interval = 1000 / requestsPerSecond;
							let counter = 0;

							// Call the API every `interval` milliseconds
							setInterval(() => {
							    if(counter <= 20) {
							        counter++;
							        fetch(url + '?api_request='+requestsPerSecond)
									.then(response => response.text())
							        .then(text => {
							            document.getElementById("responseSection").innerHTML += '<div>' + text + '</div>';
							            //console.log(response);
							        })
							        .catch(error => {
							            console.log('error');
							        });
							    }
							}, interval);
						}
					</script>
				</head>
				<body>
					<input type="text" name="api_request" id="api_request" placeholder="#of Requests"/> <input type="button" name="run_api" value="Run" onclick="makeApiRequests()" /><div id="responseSection"></div>
				</body>
			</html>
		<?php
	}
?>


				