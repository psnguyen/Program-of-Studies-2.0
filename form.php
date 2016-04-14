<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>
<?php
	$dbFile = fopen('db/db.json', 'r');
	$dbJSON = fread($dbFile, filesize('db/db.json'));
	fclose($dbFile);
	$dbPHP = json_decode($dbJSON, true);
	$id = $_GET["id"];
	$data = $dbPHP["users"][$id];
	if($data == NULL){
		//header('This is not the page you are looking for', true, 404);
	    include('error.html');
		exit();
	}
?>

<head>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,400italic,300italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <style type="text/css" media="print">
        @page 
	    {
	        size: auto;   /* auto is the initial value */
	        margin: 0mm !important;  /* this affects the margin in the printer settings */
	    }

		#error{ display: none; }
		#instructions{ display: none; }
		input[type="number"]{
		   width:100px;
			-moz-appearance: textfield;
		}
		/* Remove controls from Safari and Chrome */
		input[type=number]::-webkit-inner-spin-button, 
		input[type=number]::-webkit-outer-spin-button { 
		  -webkit-appearance: none;
		  margin: 0; /* Removes leftover margin */
		}
		input[type="button"]{ display: none;}
		#section_4{ padding-top: 0px; }
		select{
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			border: none;
			text-align: center;
		}
		select::-ms-expand { display: none; }
		.hide{ display: none;}
	</style>

	<style type="text/css" media="screen">
    	#error{
    		color:red;
    	}

    </style>
    <style>
        table,tr,th,td{
        	border: black solid 1px;
        }
		input[type="number"] {
		   width:100px;
		}

		#section_0{
			margin: auto;
		}

		#transfer_field{
			width: 400px;
			text-align: left;
		}

		#section_5{
			width: 600px;
		}

		.grad-courses{
			display: inline-block;
		}

    </style>

	<script language="javascript" type="text/javascript">
		function removeSpaces(string) {
			return string.split(' ').join('');
		};

		function remove_spaces(elem){
			elem.value = removeSpaces(elem.value);
		};

		function check_units(elem){
 			if(elem.value < 0)
 				elem.value = 0;
		};
	</script>


</head>

<script type="text/javascript">
	var user_data = <?php
		$dbFile = fopen('db/db.json', 'r');
		$dbJSON = fread($dbFile, filesize('db/db.json'));
		fclose($dbFile);
		$dbPHP = json_decode($dbJSON, true);
		$id = $_GET["id"];
		$data = $dbPHP["users"][$id];
		if($data == NULL){
			//header('This is not the page you are looking for', true, 404);
		    include('error.html');
			exit();
		}
		print json_encode($data);
	?>;

	var user_link = <?php 
		print "'http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]'";  
	?>;

</script>

<script src ="verify.js"></script>

<!-- <div id="bg"></div> -->
<body>

<form name="the_form">
<div id= "form_fields">
    <img src="scu.jpg" style = "float:left" height="62" width ="62"/>
    <center>
        <h2>
        	Poseidon: Program of Studies
        	<br>
        	M.S. Computer Science &amp; Engineering
        </h2>

		<center id="instructions">
		Fill out the fields below. Click <b>verify</b> to check your work (only the first error will be shown)! You may hit <b>save</b> or <b>print</b> at any time. <a href="safari.gif">Disable headers</a>!
		<br>
		<?php
		    echo "Your form URL is: <a href='http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]'>http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]</a>";
		?>
		</center>

        <!-- BEGIN SECTION 0 -->

        <br class="hide">

        <div id="section_0">
			<span>
				Name: <input type="text" id="name_field" >
		   		E-mail: <input type="text" id="email_field" >
		   		<br>
		   		Date: <input type="text" id="date_field" >
				Student ID: <input type="number" id="student_id_field" min=0>
			</span>

			<br>
			<br>

			<div id="transfer_field">
				<input type="radio" name="status" value="transfer">Transfer Student (Outside SCU) (9 Units)
				<br>
				<input type="radio" name="status" value="scu_undergrad">SCU Undergrad Student (Non-Five Year) (16 Units)
				<br>
				<input type="radio" name="status" value="five_year">SCU Undergrad (Five Year) (20 Units)
				<br>
				<br>
			</div>

		</div>

		<script type="text/javascript">
			document.getElementById("name_field").value = user_data.name_field;
			document.getElementById("email_field").value = user_data.email_field;
			document.getElementById("date_field").value = user_data.date_field;
			document.getElementById("student_id_field").value = user_data.student_id_field;
			var statuses = document.getElementsByName("status");
			for(var i = 0; i < statuses.length; i++){
				if(statuses[i].value == user_data.transfer_status){
					statuses[i].checked = true;
					break;
				}
			}
		</script>

		<!-- END SECTION 0 -->

		<!-- BEGIN SECTION 1: APPROVED TRANSFER CREDITS -->

		<div id="section_1">
			<b>Approved Transfer Credit</b>
			<br>
			<i>(Note: 3 semester units = 4.5 quarter units)</i>
			<br>
			<br>
			<table id="section_1_table">
				<th>Course #</th>
				<th>Institution</th>
				<th>Grade</th>
				<th>Quarter Units</th>
				<tr>
					<td> <input type="text" name="transfer_course" onblur="remove_spaces(this)" placeholder="e.g. COEN 129"> </td>
					<td> <input type="text" name="institution" placeholder="Santa Clara University"> </td>
					<td> <input type="text" name="grade" placeholder="A-"> </td>
					<td> <input type="number" name="transfer_units" min=0 onblur="check_units(this)" placeholder="4"> </td>
				</tr>
				<tr>
					<td> <input type="text" name="transfer_course" onblur="remove_spaces(this)"> </td>
					<td> <input type="text" name="institution" > </td>
					<td> <input type="text" name="grade" > </td>
					<td> <input type="number" name="transfer_units" min=0 onblur="check_units(this)"> </td>

				</tr>
				<tr>
					<td> <input type="text" name="transfer_course" onblur="remove_spaces(this)"> </td>
					<td> <input type="text" name="institution" > </td>
					<td> <input type="text" name="grade" > </td>
					<td> <input type="number" name="transfer_units" min=0 onblur="check_units(this)"> </td>

				</tr>
				<tr>
					<td> <input type="text" name="transfer_course" onblur="remove_spaces(this)"> </td>
					<td> <input type="text" name="institution" > </td>
					<td> <input type="text" name="grade" > </td>
					<td> <input type="number" name="transfer_units" min=0 onblur="check_units(this)"> </td>

				</tr>
				<tr>
					<td> <input type="text" name="transfer_course" onblur="remove_spaces(this)"> </td>
					<td> <input type="text" name="institution" > </td>
					<td> <input type="text" name="grade" > </td>
					<td> <input type="number" name="transfer_units" min=0 onblur="check_units(this)"> </td>

				</tr>
				<tr>
					<td> <input type="text" name="transfer_course" onblur="remove_spaces(this)"> </td>
					<td> <input type="text" name="institution" > </td>
					<td> <input type="text" name="grade" > </td>
					<td> <input type="number" name="transfer_units" min=0 onblur="check_units(this)"> </td>

				</tr>
			</table>
		</div>

		<script type="text/javascript">
			var transfer_course_fields = document.getElementsByName("transfer_course");
			var institution_fields = 	document.getElementsByName("institution");
			var grade_fields 		= 	document.getElementsByName("grade");
			var transfer_units_fields = document.getElementsByName("transfer_units");

			for(var i = 0; i < user_data.section_1_courses.length; i++){			
				transfer_course_fields[i].value = user_data.section_1_courses[i].course;
				institution_fields[i].value 	= user_data.section_1_courses[i].institution;
				grade_fields[i].value 			= user_data.section_1_courses[i].grade;
				transfer_units_fields[i].value	= user_data.section_1_courses[i].units;
			}
		</script>

		<!-- END SECTION 1 -->

		<br>

		<!-- BEGIN SECTION 2-->

		<div id="section_2">

			<b>Foundation Courses</b>
			<br>
			<i>Mark the courses (or equivalences) the student is required to take</i>
			<br>
			<br>

			<table>
				<th>Course #</th>
				<th>Required?</th>
				<tr>
					<td><b>COEN 20</b> (Assembly Language)</td>
					<td id="COEN20">
						<input type="radio" name="COEN20" value="yes">Yes
						<input type="radio" name="COEN20" value="no">No
					</td>
				</tr>

				<tr>
					<td><b>COEN 21</b> (Logic Design)</td>
					<td id="COEN21">
						<input type="radio" name="COEN21" value="yes">Yes
						<input type="radio" name="COEN21" value="no">No
					</td>
				</tr>

				<tr>
					<td><b>COEN 11</b> (Advanced Programming)</td>
					<td id="COEN11">
						<input type="radio" name="COEN11" value="yes">Yes
						<input type="radio" name="COEN11" value="no">No
					</td>
				</tr>

				<tr>
					<td><b>COEN 12</b> (Data Structures)</td>
					<td id="COEN12">
						<input type="radio" name="COEN12" value="yes">Yes
						<input type="radio" name="COEN12" value="no">No
					</td>
				</tr>

				<tr>
					<td><b>COEN 19</b> (Discrete Math)</td>
					<td id="COEN19">
						<input type="radio" name="COEN19" value="yes">Yes
						<input type="radio" name="COEN19" value="no">No
					</td>
				</tr>

				<tr>
					<td><b>AMTH 210</b> (Probability)</td>
					<td id="AMTH210">
						<input type="radio" name="AMTH210" value="yes">Yes
						<input type="radio" name="AMTH210" value="no">No
					</td>
				</tr>

				<tr>
					<td><b>AMTH 106</b> OR <b>AMTH 220&amp;221</b> OR <b>AMTH 245&amp;246</b></td>
					<td id="AMTH*">
						<input type="radio" name="AMTH*" value="yes">Yes
						<input type="radio" name="AMTH*" value="no">No
					</td>
				</tr>

			</table>
		</div>
		
		<script type="text/javascript">
		// var foundation_courses = document.querySelectorAll('input[type = "checkbox"]');
		// for(var i = 0; i < user_data.section_2_courses.length; i++){
		// 	foundation_courses[i].checked = user_data.section_2_courses[i].required;
		// }

			var sec_2_courses = [
				document.getElementById("COEN20"),
				document.getElementById("COEN21"),
				document.getElementById("COEN11"),
				document.getElementById("COEN12"),
				document.getElementById("COEN19"),
				document.getElementById("AMTH210"),
				document.getElementById("AMTH*")
			];

			if(user_data.section_2_courses[0] != undefined){
				for(var i = 0; i < sec_2_courses.length; i++){
					var current_course = sec_2_courses[i].children;
					var req = user_data.section_2_courses[i].required;
					if(req)
						current_course[0].checked = true;
					else
						current_course[1].checked = true;
				}
			}


		</script>

		<!-- END SECTION 2 -->

		<br>
		<br>
		<br>

		<!-- BEGIN SECTION 3 -->

		<div id="section_3">

			<b>Computer Science and Engineering Core Courses</b>
			<br>
			<i>Mark the appropriate box for the following courses (4 units each).</i>
			<br>
			<br>

			<table>
				<tr>
					<td>COEN 210</td>
					<td>COEN 279</td>
					<td>COEN 283</td>
				</tr>
				<tr>
					<td>
						<select id="COEN210">
							<option value="e" name="210_empty"></option>
							<option value="w" name="210_waived">Waived</option>
							<option value="r" name="210_required">Required</option>
							<option value="t" name="210_transferred">Transferred</option>
						</select>
					</td>
					<td>
						<select id="COEN279">
							<option value="e" name="279_empty"></option>
							<option value="w" name="279_waived">Waived</option>
							<option value="r" name="279_required">Required</option>
							<option value="t" name="279_transferred">Transferred</option>
						</select>
					</td>
					<td>
						<select id="COEN283">
							<option value="e" name="283_empty"></option>
							<option value="w" name="283_waived">Waived</option>
							<option value="r" name="283_required">Required</option>
							<option value="t" name="283_transferred">Transferred</option>
						</select>
					</td>
				</tr>
			</table>
		</div>

		<script type="text/javascript">
			var sec_3_courses = [ 
				document.getElementById("COEN210"),
				document.getElementById("COEN279"),
				document.getElementById("COEN283")
			];

			for(var i = 0; i < user_data.section_3_courses.length; i++){
				var stat = user_data.section_3_courses[i].status;
				var index;
				if(stat == "e")
					index = 0;
				else if(stat == "w")
					index = 1;
				else if (stat == "r")
					index = 2;
				else if (stat == "t")
					index = 3;
				sec_3_courses[i].selectedIndex = index;
			}

		</script>

		<!-- END SECTION 3 -->

		<br>

		<!-- BEGIN SECTION 4 -->

		<div id="section_4">

			<b>SCU Graduate Core Requirements </b>
			<br>
			<i>(min. 6 units total), 1 course from each area</i>
			<br>
			<br>

			<table>
				<th>Core Requirement</th>
				<th>Course #</th>
				<th>Units</th>
				<tr>
					<td>Emerging Topics in Engineering</td>
					<td><input type="text" name="core_class" onblur="remove_spaces(this)" placeholder="e.g. ENGR 300"> </td>
					<td><input type="number" name="core_units" min=0 onblur="check_units(this)" placeholder="4"></td>
				</tr>
				<tr>
					<td>Engineering and Business/Entrepreneurship</td>
					<td><input type="text" name="core_class" onblur="remove_spaces(this)"></td>
					<td><input type="number" name="core_units" min=0 onblur="check_units(this)"></td>
				</tr>
				<tr>
					<td>Engineering and Society</td>
					<td><input type="text" name="core_class" onblur="remove_spaces(this)"></td>
					<td><input type="number" name="core_units" min=0 onblur="check_units(this)"></td>
				</tr>

			</table>
		</div>

		<script type="text/javascript">
			var core_courses = document.getElementsByName("core_class");
			var core_units = document.getElementsByName("core_units");
			for(var i = 0; i < user_data.section_4_courses.length; i++){
				core_courses[i].value = user_data.section_4_courses[i].course;
				core_units[i].value = user_data.section_4_courses[i].units;
			}
		</script>

		<!-- END SECTION 4 -->

		<br>

		<!-- BEGIN SECTION 5-->

		<div id="section_5">

			<b>Additional Graduate Courses </b>
			<br>
			<i>List track courses and additional courses totaling to 45 graduate units</i>
			<br>
			<i>(Must have minimum 8 COEN units with course numbers over 300!)</i>
			<br>
			<br>

			Track: <input type="text" name="track">
		   
			<br>
			<br> 


			<span id="container-5">   
				<table class="grad-courses">
					<th>Course #</th>
					<th>Units</th>
					<tr>
						<td> <input type="text" name="grad_course" onblur="remove_spaces(this)"> </td>
						<td> <input type="number" name="course_units" min=0 onblur="check_units(this)"> </td>
					</tr>
					<tr>
						<td> <input type="text" name="grad_course" onblur="remove_spaces(this)"> </td>
						<td> <input type="number" name="course_units" min=0 onblur="check_units(this)"> </td>
					</tr>
					<tr>
						<td> <input type="text" name="grad_course" onblur="remove_spaces(this)"> </td>
						<td> <input type="number" name="course_units" min=0 onblur="check_units(this)"> </td>
					</tr>
					<tr>
						<td> <input type="text" name="grad_course" onblur="remove_spaces(this)"> </td>
						<td> <input type="number" name="course_units" min=0 onblur="check_units(this)"> </td>
					</tr>
					<tr>
						<td> <input type="text" name="grad_course" onblur="remove_spaces(this)"> </td>
						<td> <input type="number" name="course_units" min=0 onblur="check_units(this)"> </td>
					</tr>
					<tr>
						<td> <input type="text" name="grad_course" onblur="remove_spaces(this)"> </td>
						<td> <input type="number" name="course_units" min=0 onblur="check_units(this)"> </td>
					</tr>
				</table>
				<table class="grad-courses">
					<th>Course #</th>
					<th>Units</th>
					<tr>
						<td> <input type="text" name="grad_course" onblur="remove_spaces(this)"> </td>
						<td> <input type="number" name="course_units" min=0 onblur="check_units(this)"> </td>
					</tr>
					<tr>
						<td> <input type="text" name="grad_course" onblur="remove_spaces(this)"> </td>
						<td> <input type="number" name="course_units" min=0 onblur="check_units(this)"> </td>
					</tr>
					<tr>
						<td> <input type="text" name="grad_course" onblur="remove_spaces(this)"> </td>
						<td> <input type="number" name="course_units" min=0 onblur="check_units(this)"> </td>
					</tr>
					<tr>
						<td> <input type="text" name="grad_course" onblur="remove_spaces(this)"> </td>
						<td> <input type="number" name="course_units" min=0 onblur="check_units(this)"> </td>
					</tr>
					<tr>
						<td> <input type="text" name="grad_course" onblur="remove_spaces(this)"> </td>
						<td> <input type="number" name="course_units" min=0 onblur="check_units(this)"> </td>
					</tr>
					<tr>
						<td> <input type="text" name="grad_course" onblur="remove_spaces(this)"> </td>
						<td> <input type="number" name="course_units" min=0 onblur="check_units(this)"> </td>
					</tr>
				</table>
			</span>

		</div>

		<script type="text/javascript">
			document.getElementsByName("track")[0].value = user_data.track;
			var grad_courses = document.getElementsByName("grad_course");
			var grad_units = document.getElementsByName("course_units");
			for(var i = 0; i < user_data.section_5_courses.length; i++){
				grad_courses[i].value = user_data.section_5_courses[i].course;
				grad_units[i].value = user_data.section_5_courses[i].units;
			}
		</script>

		<!-- END SECTION 5 -->

		<br>

		<!-- BEGIN SECTION 6 -->

		<span> 
			<b>Total Graduate Units:</b>
	    	<input type="number" name="total_units" readonly> 
	    	<input type="button" onclick="verify('<?php print $_GET["id"] ?>')" value="Verify">
	    </span>

	    <script type="text/javascript">
	    	document.getElementsByName("total_units")[0].value = user_data.total_units;
	    </script>

	    <br>
	    
	    <div id="error"></div>
	    
	    <br><br>
	    
	    Student Signature/Date:______________________________________________________
	    <br><br><br>
	    Advisor Name/Signature/Date:_________________________________________________
	    
	    <!-- END SECTION 6 -->

	    <br>
	    <br>


	   	<input type="button" name="print_doc" value="Print Form" onclick="print_page('<?php print $_GET["id"] ?>')">
   		<input type="button" name="save" value="Save Form" onclick="start_save('<?php print $_GET["id"] ?>')">

 
	</center> 
</div>
</form>


</body>
</html>
