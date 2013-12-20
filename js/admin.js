$('#family_name').blur(function(callback) {
	var value = $(this).find(":selected").text();
	// console.log(value);
	if (value == "" || value == "Select a family") {
		$('#family_name_error').html("** This field can't be empty");
	} else {
		$('#family_name_error').html("");
 	}
});

$('input[name=email]').blur(function(callback) {
	var value = $(this).val();
	console.log(value);
	if (value == "") {
		$('#email_error').html("This field can't be empty");
	} else {
		var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if (!emailRegex.test(value)) {
			$('#email_error').html("** This is not a valid email address");
			console.log("This is not a valid email address");
		} else {
			$('#email_error').html("");
			console.log("This is a valid email address");
		}
 	}
});

$('input[name=first_name]').blur(function(callback) {
	if ($(this).val() == "") {
		$('#first_name_error').html("** This field can't be empty");
	} else {
		$('#first_name_error').html("");
	}
});

$('input[name=last_name]').blur(function(callback) {
	if ($(this).val() == "") {
		$('#last_name_error').html("** This field can't be empty");
	} else {
		$('#last_name_error').html("");
	}
});

$('input[name=password]').blur(function(callback) {
	var value = $(this).val();
	var msg = "";
	if ( value == "") {
		$('#password_error').html("** This field can't be empty");
	} else {
		if (value.length < 6) {
			msg = msg + "at least 6 characters long" + "<br>";
		}
		var digitRegex = /[0-9]+/;
		if (!digitRegex.test(value)) {
			msg = msg + "at least 1 digit" + "<br>";
		} 
		var specialcharRegex = /[$%#@&]+/;
		if (!specialcharRegex.test(value)) {
			msg = msg + "at least 1 special character" + "<br>";
		} 
		$('#password_error').html(msg);
	}
});

$('input[name=password2]').blur(function(callback) {
	var password2 = $(this).val();
	var password = $('input[name=password]').val();
	
	if ( password2 != password) {
		$('#password2_error').html("** Password is not matched");
	} else {
		$('#password2_error').html("");
	}
});

function validateFamily(formname) {
	if (formname.family_name.value == "") {
		alert ("Family name can't be empty");
		// console.log("Family name can't be empty");
		return false;
	}
	else {
		return true;
	}
}

function validateAddUser(formname) {
	var error_msg = "";
	var error_found = 0;
	var element = document.getElementById('family_name_dd');
	var family_name = element.options[element.selectedIndex].text;
	
	if (family_name == "" || family_name == "Select a family") {
		error_msg = error_msg + "Family is required.\n";
		// alert (error_msg);
		error_found++ ;
		// console.log (error_found++ + " : " + error_msg);
		// return false;
	}

	var email = formname.email.value;
	if (email == "") {
			error_msg = error_msg + "Email is required.\n"
			error_found++ ;
	} else {
		var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if (!emailRegex.test(email)) {
			error_msg = error_msg + "Email address is invalid\n";
			error_found++ ;
			// console.log("This is not a valid email address");
		}
 	}	

	if (formname.first_name.value == "" ) {
		error_msg =  error_msg + "First name is required\n";
		error_found++ ;
	}

	if (formname.last_name.value == "" ) {
		error_msg =  error_msg + "Last name is required\n";
		error_found++ ;
	}

	password = formname.password.value;
	if (password == "" ) {
		error_msg =  error_msg + "Password is required\n";
		error_found++ ;
	} else {
		var non_legit_password = 0;
		if (password.length < 6) {
			error_msg = error_msg + "Password at least 6 characters long\n";
			non_legit_password ++;
		}
		var digitRegex = /[0-9]+/;
		if (!digitRegex.test(password)) {
			error_msg = error_msg + "Password at least 1 digit\n";
			non_legit_password ++;
		} 
		var specialcharRegex = /[$%#@&]+/;
		if (!specialcharRegex.test(password)) {
			error_msg = error_msg + "Password at least 1 special character\n";
			non_legit_password ++;
		}
	}

	// if this is a legit password, then check one more thing
	// that if password2 matches it
	var password2 = formname.password2.value;
	if (!non_legit_password) {
		if (password != password2 ) {
			error_msg = error_msg + "Passwords are not match\n";
			error_found ++;			
		}
	}
	
	if (error_found) { 
		alert (error_msg);
		// console.log("error_found: " + error_found);
		// console.log(error_msg);
		return false; 
	} else {
		return true;
	}
 	
}	

$(".admin-update-family-headcount").on("change", function() {
	var submit_button = $(this).closest('form').find(':submit');
	submit_button.show();
})

$(".admin-update-family-senior").on("change", function() {
	var submit_button = $(this).closest('form').find(':submit');
	submit_button.show();
})

$(".admin-update-family-children").on("change", function() {
	var submit_button = $(this).closest('form').find(':submit');
	submit_button.show();
})

$(".admin-update-family-expenses").on("change", function() {
	var submit_button = $(this).closest('form').find(':submit');
	submit_button.show();
})

$(".admin-update-family-tasks").on("change", function() {
	var submit_button = $(this).closest('form').find(':submit');
	submit_button.show();
})