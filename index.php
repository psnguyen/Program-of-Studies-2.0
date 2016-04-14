<!DOCTYPE html>
<html>
<head>
	<title>Poseidon</title>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,400italic,300italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<style type="text/css">
		#center{
			padding: 55px;
			width: 500px;
			margin: auto;
			text-align: center;
			background: rgba(250,250,250,.75);
			border: rgba(0,0,0,.7) solid 8px;
		}
		h1{
			margin: 0;
		}
		input{
			width: 200px;
			height: 30px;
		}
		#bg{
			background: url("bg.jpg");
			opacity: .9;
			background-size: cover;
			width: 100vw; height: 100vh;
			z-index: -1;
			position: absolute;
			margin: 0; padding: 0;
		}
		body{
			margin: 0;padding: 0;
			text-shadow: #FFF 2px 1px;
		}
	</style>
</head>
<body>
	<div id="bg"></div>

	<br><br><br>
	<br><br><br>
	<br><br><br>

	<div id="center">
		<h1>Poseidon</h1>
		<b><i>Santa Clara Program of Studies</i></b>

		<hr>
		
		<p>Select <i>Create Form</i> to start a new Program of Studies form, or go to the url of your saved form to load an existing one!</p>

		<form method="POST" action="createform.php">
			<input name="create" type="submit" value="Create Form">

		</form>
		
	</div>

</body>
</html>
