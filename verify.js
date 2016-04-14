/*
	user_data -> super object of the latest data, accessible anywhere!
	
	err_log(str, item) 
		-> logs error on page and points to err field
	err_clear() 
		-> clears error div
	scrape_page(id, err_checking) 
		-> collects all fields on page into json object
		-> returns json object for a given page id
		-> err_checking = true
			-> counts incomplete fields
			-> checks class spellings (TODO)
			-> calls count_units, prints out error found
			-> returns data object only as far as function got before failure
		-> err_checking = false
			-> collects all fields and returns data object
	verify(id)
		-> calls scrape_page() with err_checking set to true
		-> this checks page for errors (see: err_checking = true in scrape_page)
	count_units(data)
		-> takes json object of all fields in page
		-> returns sum of units and any errors
	print_page(id) 
		-> verifies that page is correct
		-> calls window.print() on the page
	save(data) 
		-> takes json object, sends to saveform.php
	start_save()
		-> scrapes page into data object
		-> calls save(data) on data object to send over to server

*/


/* suggesting user saves before closing window */
var saved = false;
window.onbeforeunload = exit_prompt;
function exit_prompt(){
	if(!saved)    	
    	return "You haven't saved your progress! You probably should.";
}

/* prevent ctrl+p or cmd+p usage */
document.onkeydown = function(e){
    if( (e.ctrlKey || e.metaKey || (e.keyCode == 224 || e.keyCode == 17 || e.keyCode == 91 || e.keyCode == 93) ) && 
    	(e.key == "p" || e.charCode == 16 || e.charCode == 112 || e.keyCode == 80) ){
        
        alert("Please use the Print button below for a better rendering of the document!");
        e.cancelBubble = true;
        e.preventDefault();
        e.stopImmediatePropagation();
    }  	
};



/* here are our three buttons */
function print_page(id){
	verify(id);
	var err = document.getElementById("error").innerHTML;
	if(err == "" || err == "All good."){
		window.print();
	}
}

function start_save(id){
	var data = scrape_page(id, false);
	save(data);
};

function verify(id){
	var data = scrape_page(id, true);
};



function err_log(str, item){
	document.getElementById("error").style.color = "red";
	err_link = " <a href='#" + item + "'>Go to field.</a>";
	console.log("error!");
	document.getElementById("error").innerHTML = str + err_link;
};

function err_clear(){
	document.getElementById("error").style.color = "green";
	document.getElementById("error").innerHTML = "All good.";
};

function scrape_page(id, err_checking){
	var data = {
		"id" : id,
		"name_field" : "",
		"email_field" : "",
		"date_field" : "",
		"student_id_field" : "",
		"transfer_status" : "",
		"section_1_courses" : [
		],
		"section_2_courses" : [
		],
		"section_3_courses" : [
		],
		"section_4_courses" : [
		],
		"track" : "",
		"section_5_courses" : [
		],
		"total_units" : 0
	};

	/* section 0 */
	data.name_field = document.getElementById("name_field").value;
	data.email_field = document.getElementById("email_field").value;
	data.date_field = document.getElementById("date_field").value;
	data.student_id_field = document.getElementById("student_id_field").value;
	var transfer_status = document.querySelector('input[name="status"]:checked');

	if(err_checking){
		if(data.name_field == ""){
			err_log("No name entered. ", "name_field");
			return data;
		}
		if(data.email_field == ""){
			err_log("No email entered. ", "email_field");
			return data;
		}
		if(data.date_field == ""){
			err_log("No date entered. ", "date_field");
			return data;
		}
		if(data.student_id_field == ""){
			err_log("No student ID entered. ", "student_id_field");
			return data;
		}

		if(transfer_status == null){
			err_log("Please select your transfer status. ", "transfer_field");
			return data;
		}

		function clean_input(str){
			var clean_str
			return clean_str;
		}

		/* appropriate field entries */
		var letters = /^[0-9a-zA-Z ]+$/;
		if( data.name_field.match(letters) == null ){
			console.log("j");
			return;
		}
	}

	if(transfer_status == null)
		data.transfer_status = null;
	else
		data.transfer_status = document.querySelector('input[name="status"]:checked').value;


	/* section 1 */
	var transfer_course_fields = document.getElementsByName("transfer_course");
	var institution_fields 	= 	document.getElementsByName("institution");
	var grade_fields 		= 	document.getElementsByName("grade");
	var transfer_units_fields = document.getElementsByName("transfer_units");

	for(var i = 0; i < transfer_course_fields.length; i++){	
		var section_1_obj = {};		
		section_1_obj.course 		= 	transfer_course_fields[i].value.toUpperCase();
		section_1_obj.institution 	= 	institution_fields[i].value ;
		section_1_obj.grade			= 	grade_fields[i].value ;
		section_1_obj.units 		= 	transfer_units_fields[i].value;

		var empty_row = section_1_obj.course == "" && section_1_obj.institution == "" && section_1_obj.grade == "" && section_1_obj.units == "";

		if(err_checking && !empty_row){
			var row_cols = document.getElementById("section_1_table").rows[i+1].children;
			if(section_1_obj.course == ""){
				var err_col = row_cols[0].children[0].id="err_col" + Math.random();
				err_log("Incomplete transfer course row. Invalid course name.", err_col);
				return data;
			}
			if(section_1_obj.institution == ""){
				var err_col = row_cols[1].children[0].id="err_col" + Math.random();
				err_log("Incomplete transfer course row. Invalid institution.", err_col);				
				return data;
			}
			if(section_1_obj.grade == ""){
				var err_col = row_cols[2].children[0].id="err_col" + Math.random();
				err_log("Incomplete transfer course row. Invalid grade.", err_col);
				return data;
			}
			if(section_1_obj.units == ""){
				var err_col = row_cols[3].children[0].id="err_col" + Math.random();
				err_log("Incomplete transfer course row. Invalid unit count.", err_col);
				return data;
			}
		}

		data.section_1_courses[i] = section_1_obj;
	}

	/* section 2 */

	var sec_2_courses = [
		document.getElementById("COEN20"),
		document.getElementById("COEN21"),
		document.getElementById("COEN11"),
		document.getElementById("COEN12"),
		document.getElementById("COEN19"),
		document.getElementById("AMTH210"),
		document.getElementById("AMTH*")
	];

	for(var i = 0; i < sec_2_courses.length; i++){
		var section_2_obj = {};
		section_2_obj.course = sec_2_courses[i].id.toUpperCase();
		section_2_obj.required = sec_2_courses[i].children[0].checked ? true : false;

		if(err_checking){
			var sec_2_row = sec_2_courses[i].children;
			if(!sec_2_row[0].checked && !sec_2_row[1].checked){
				var err_row = sec_2_row[0].id="err" + Math.random();
				err_log("Incomplete Foundation Course field. Please select if course is required.", err_row);
				return data;
			}
		}

		data.section_2_courses[i] = section_2_obj;
	}

	/* section 3 */
	var sec_3_courses = [ 
		document.getElementById("COEN210"),
		document.getElementById("COEN279"),
		document.getElementById("COEN283")
	];

	for(var i = 0; i < sec_3_courses.length; i++){
		var section_3_obj = {};
		section_3_obj.course = sec_3_courses[i].id.toUpperCase();
		section_3_obj.status = sec_3_courses[i].options[sec_3_courses[i].selectedIndex].value;

		if(err_checking){
			if(section_3_obj.status == "e"){
				var err_field = sec_3_courses[i].id;
				err_log("Incomplete COEN Core course field. Please select a status. ", err_field)
				return data;
			}
		}

		data.section_3_courses[i] = section_3_obj;
	}

	if(err_checking)
		err_clear();


	/* section 4 */
	var core_courses = document.getElementsByName("core_class");
	var core_units = document.getElementsByName("core_units");
	for(var i = 0; i < core_courses.length; i++){
		var section_4_obj = {};
		section_4_obj.course = core_courses[i].value.toUpperCase();
		section_4_obj.units = core_units[i].value;

		if(err_checking){
			if(section_4_obj.course == ""){
				var err_field = core_courses[i].id = "err" + Math.random();
				err_log("Incomplete Grad Core course field. Enter a course (e.g. ENGR200).", err_field);
				return data;
			}
			if(section_4_obj.units == ""){
				var err_field = core_units[i].id = "err" + Math.random();
				err_log("Incomplete Grad Core course field. Enter units for your course.", err_field);
				return data;
			}
		}

		data.section_4_courses[i] = section_4_obj;
	}

	/* section 5 */

	data.track = document.getElementsByName("track")[0].value;
	
	if(err_checking){
		if(data.track == ""){
			var err_field = document.getElementsByName("track")[0].id = "err" + Math.random();
			err_log("Please enter your track.", err_field);
			return data;
		}
	}

	var grad_courses = document.getElementsByName("grad_course");
	var grad_units = document.getElementsByName("course_units");
	for(var i = 0; i < grad_courses.length; i++){
		var section_5_obj = {};
		section_5_obj.course = grad_courses[i].value.toUpperCase();
		section_5_obj.units = grad_units[i].value;

		var empty_row = section_5_obj.course == "" && section_5_obj.units == "";

		if(err_checking && !empty_row){
			if(section_5_obj.course == ""){
				var err_field = grad_courses[i].id = "err" + Math.random();
				err_log("Incomplete Additional Grad courses field. Enter a course (e.g. COEN301).", err_field);
				return data;
			}
			if(section_5_obj.units == ""){
				var err_field = grad_units[i].id = "err" + Math.random();
				err_log("Incomplete Additional Grad course units field. Enter units for your course.", err_field);
				return data;
			}
		}

		data.section_5_courses[i] = section_5_obj;
	}

	// else if verifying, count up the units (which will also update the field)
	if(err_checking)
		count_units(data); 

	// if just saving, will grab the last value in the field. if we verified, grabs new value
	data.total_units = document.getElementsByName("total_units")[0].value;
	
	return data;

}

function save(data) {

	console.log("inside save(), here is data: ", data);

	// now that we counted the units, we must add to the data payload
	data.total_units = document.getElementsByName("total_units")[0].value;
	
	// send object to saveform.php
	var str_json = JSON.stringify(data);
    var request = new XMLHttpRequest();
    request.open("POST", "saveform.php", true);
    request.setRequestHeader("Content-type", "application/json")
    request.send(str_json);

	alert('Form has been saved. Save or bookmark the link to your form! You can access it in the future from this link: ' + user_link);

	user_data = data;
	saved = true;
}

/* 
	This function is only called if we err_checking is true, 
	so assume we were passed a correctly parsed object 
*/
function count_units(data){
	// accounting for transfer rules
	var transfer_status = data.transfer_status;

	// checking for dupe courses

	var sections = [
		data.section_1_courses,
		data.section_2_courses,
		data.section_3_courses,
		data.section_4_courses,
		data.section_5_courses
	];

	/* data structure that keeps track of all courses and how many times they occur */
	var courses = {};

	/* 
		count occurrences of all courses on page.
		this section is the only check for duplicate courses.
	*/
	for(var i = 0; i < sections.length; i++){
		for(var j = 0; j < sections[i].length; j++){
			var course_name = sections[i][j].course;

			/* if course doesn't exist, add it */
			if(courses[course_name] == null || course_name == ""){
				courses[course_name] = 1;
			}
			/* else we have an error and stop parsing */
			else {
				document.getElementById("error").style.color = "red";
				document.getElementById("error").innerHTML = "Duplicate course: " + course_name;
				return;
			} 
		}
	}

	// if we made it here, we have no duplicate courses
	console.log("No duplicate courses. Continuing with unit counts...");





	/* section 4 min 6 units) */
	var core_engr_course_units = 0;

	// iterate through list of classes
	for(i = 0; i < data.section_4_courses.length; i++){
		core_engr_course_units += parseInt(data.section_4_courses[i].units,10);
	}

	if(core_engr_course_units < 6){
		document.getElementById("error").style.color = "red";
		document.getElementById("error").innerHTML = "Must include a minimum of 6 units of Graduate Core Requirements courses. Currently at " + core_engr_course_units + " units.";	
		return;
	}



	/* section 5 min 8 COEN units > 300) */
	var grad_coen_course_units = 0;

	// iterate through list of classes, e.g. COEN311, 4 units
	for(i = 0; i < data.section_5_courses.length; i++){
		var course_name, course_number_str;
		var course_units = data.section_5_courses[i].units;
		
		try {
			course_name = data.section_5_courses[i].course.substring(0,4).toUpperCase();
			course_number_str = data.section_5_courses[i].course.substring(4);
			course_number = parseInt(course_number_str,10);
			if(course_name == "COEN" && course_number_str >= 300){
				grad_coen_course_units += parseInt(course_units,10);
			}
		}
		catch(err) {
			console.log(err);
		}
	}

	if(grad_coen_course_units < 8){
		document.getElementById("error").style.color = "red";
		document.getElementById("error").innerHTML = "Must include a minimum of 8 units of COEN courses with course numbers greater than 300. No exceptions. Currently at " + grad_coen_course_units + " units.";	
		return;
	}



	

	/* 
		Now that we have checked that there are no duplicates, the only
		part left is to check that our student has enough units.
	*/

	// sum of total units
	var sum = 0;

	// sum of transferrable units
	var transfer_sum = 0;

	// section 1 (transfer courses)
	for(var i = 0; i < data.section_1_courses.length; i++){
		var units = data.section_1_courses[i].units;
		if(units)
			transfer_sum += parseInt(units,10);
	}

	// transfer : up to 9
	// undergrad : up to 16
	// five year : up to 20
	if(transfer_status == "transfer"){
		transfer_sum > 9 ? transfer_sum = 9 : transfer_sum = transfer_sum;
	}
	else if(transfer_status == "scu_undergrad"){
		transfer_sum > 16 ? transfer_sum = 16 : transfer_sum = transfer_sum;
	}
	else if(transfer_status == "five_year"){
		transfer_sum > 20 ? transfer_sum = 20 : transfer_sum = transfer_sum;
	}
	else{
		// this shouldn't ever happen
		alert("Incorrect.");
	}
	sum += transfer_sum;



	// section 2 units aren't counted



	// section 3 is status checking, required means 4 units count, else waived and transf means no units
	for(var i = 0; i < data.section_3_courses.length; i++){
		data.section_3_courses[i].status == "r" ? sum += 4 : sum += 0;
	}

	// section 4 is grad cores 
	for(var i = 0; i < data.section_4_courses.length; i++){
		var units = data.section_4_courses[i].units;
		if(units)
			sum += parseInt(units,10);
		
	}

	// section 5 is more courses
	for(var i = 0; i < data.section_5_courses.length; i++){
		var units = data.section_5_courses[i].units;
		if(units)
			sum += parseInt(units,10);;
	}

	// inject sum
	document.getElementsByName("total_units")[0].value = sum;

	if(sum < 45){
		document.getElementById("error").style.color = "red";
		document.getElementById("error").innerHTML = "You need at least 45 units. Current units: " + sum;
	}

	return;

}
