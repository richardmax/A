window.onload = function(){
	/*
	classie.addClass(document.body, "login"),
	var sub = ("#wp-submit");
	sub.click(function() {
		classie.addClass(document.body, "register"), classie.removeClass(document.body, "login");
	});
	var sub = ("#nav a");
	sub.click(function() {
		classie.addClass(document.body, "register"), classie.removeClass(document.body, "login");
		
	});
	
	*/
	
	document.getElementById("user_login").placeholder = "Enter Username or Email Address here";
	document.getElementById("user_pass").placeholder = "Enter Password here";
	
	var sub = ("#nav a");
	sub.href="xyz.php"; 
	
};