<?php
	define("index","Welcome");
	define ("title","Web Redirector");
	require "php/server.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo title;?></title>
	<link rel="icon" href="assets/WR_LOGO.ico" type="image/gif" sizes="16x16">
	<link rel="stylesheet" type="text/css" href="node_modules/materialize-css/dist/css/materialize.min.css"/>
	 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<style>
		body {
			font-family: 'Montserrat', sans-serif;
		}
		body::-webkit-scrollbar {
		width: 1em;
		}
		
		body::-webkit-scrollbar-track {
		box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
		}
		
		body::-webkit-scrollbar-thumb {
		background-color: darkgray;
		outline: 1px solid slategrey;
		}
		h3 {
			text-align:center;
		}
	</style>
</head>
<body>
	<div class="navbar-fixed">
	    <nav class="black">
	      <div class="nav-wrapper">
	        <a onclick="refresh()" style="cursor:pointer;">Web App Redirector ver 2.0 <i class="material-icons left">donut_large</i></a>
	        <ul class="right">
				<li><i class="material-icons large modal-trigger" data-target="searchModal" style="cursor:pointer;">search</i></li>
				<li><div id="time"></div></li>
	          <li><a data-target="login_form" class="modal-trigger">Admin</a></li>
	        </ul>
	      </div>
	    </nav>
	  </div>
	
	  <center><img src="assets/loading.gif" alt="" width="100" style="display:block;" id="loading"></center>
	<main>
		<!-- <div id="dashboard" class="row"></div> -->
		<h3>All Department</h3>
		<div id="all_dept_app" class="row"></div>
		<div class="divider"></div>
		<!-- Prod Dept -->
		<h3>Production Department</h3>
		<div id="prod_dept_app" class="row"></div>
		<div class="divider"></div>
		<!-- MM dept -->
		<h3>MM Department</h3>
		<div id="mm_dept_app" class="row"></div>
		<div class="divider"></div>
		<!--HRGA dept -->
		<h3>HRGA Department</h3>
		<div id="hr_dept_app" class="row"></div>
		<div class="divider"></div>

		<!--IT dept -->
		<h3>IT Department</h3>
		<div id="it_dept_app" class="row"></div>
		<div class="divider"></div>

		<!--PE dept -->
		<h3>PE Department</h3>
		<div id="pe_dept_app" class="row"></div>
		<div class="divider"></div>

		<!--EQD dept -->
		<h3>EQD Department</h3>
		<div id="eqd_dept_app" class="row"></div>
		<div class="divider"></div>
	</main>

	

	  <!--modals-->
	  	<div class="modal" id="login_form">
	  		<div class="modal-content">
	  			<h1 class="center"><i class="material-icons">account_circle</i></h1>
	  			<form class="row" method="POST">
	  				<div class="input-field col s12">
	  					<input type="text" name="username"><label>Username</label>
	  				</div>

	  				<div class="input-field col s12">
	  					<input type="password" name="password" id="pass"><label>Password</label>
	  					<i class="material-icons prefix" style="right:0;cursor:pointer;" onclick="show_pass()" id="show">remove_red_eye</i>
	  				</div>

	  				<div class="input-field col s12">
	  					<input class="btn black" type="submit" name="login_btn" value="Login">
	  					
	  				</div>
	  			</form>
	  		</div>
	  	</div>

		<!-- searchModal -->
		<div class="modal" id="searchModal" style="width:80%;">
			<div class="modal-content">
				<div class="row">
					<div class="input-field col s12">
						<input type="text" id="searchTxt" onkeyup="search_url()" autocomplete="off"><label for="searchTxt">Find</label>
					</div>
				</div>
				<div class="divider"></div>
				<table id="searchResult"></table>
			</div>
		</div>
	  <!--javascript-->

 	<script type="text/javascript" src="node_modules/materialize-css/dist/js/jquery.min.js"></script>
 	<script type="text/javascript" src="node_modules/materialize-css/dist/js/materialize.min.js"></script>
 	<script type="text/javascript">
 		$(document).ready(function(){
 			$('.modal').modal();
			 
 		});
		 
 		function show_pass(){
 			var x = document.getElementById("pass");
 				if(x.type === "password"){
 					x.type = "text";
 					document.getElementById("show").style.color ="red";
 				}else{
 					x.type = "password";
 					document.getElementById("show").style.color ="";
 				}
 		}
		 
		
		
		load_all_dept();
		function load_all_dept(){
			var xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  var response = this.responseText;
                  document.getElementById("all_dept_app").innerHTML = response;
                 
                }
              };
              xhttp.open("GET", "php/process.php?process=load_url_all_dept", true);
              xhttp.send();
		}

		load_prod_dept();
		function load_prod_dept(){
			var xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  var response = this.responseText;
                  document.getElementById("prod_dept_app").innerHTML = response;
                 
                }
              };
              xhttp.open("GET", "php/process.php?process=load_url_prod_dept", true);
              xhttp.send();
		}

		load_prod_eqd();
		function load_prod_eqd(){
			var xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  var response = this.responseText;
                  document.getElementById("eqd_dept_app").innerHTML = response;
                 
                }
              };
              xhttp.open("GET", "php/process.php?process=load_url_eqd_dept", true);
              xhttp.send();
		}

		load_pe_dept();
		function load_pe_dept(){
			var xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  var response = this.responseText;
                  document.getElementById("pe_dept_app").innerHTML = response;
                 
                }
              };
              xhttp.open("GET", "php/process.php?process=load_url_pe_dept", true);
              xhttp.send();
		}
		load_it_dept();
		function load_it_dept(){
			var xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  var response = this.responseText;
                  document.getElementById("it_dept_app").innerHTML = response;
                 
                }
              };
              xhttp.open("GET", "php/process.php?process=load_url_it_dept", true);
              xhttp.send();
		}

		function refresh(){
			load_all_dept();
			load_prod_dept();
			load_mm_dept();
			load_hr_dept();
			load_it_dept();
			load_eqd_dept();
			load_pe_dept();	
			
		}

		$(document).ready(function(){
			setTimeout(function(){
				document.querySelector("#loading").style.display = "none";
			},5000);
		});
	
		
		load_mm_dept();
		function load_mm_dept(){
			var xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  var response = this.responseText;
                  document.getElementById("mm_dept_app").innerHTML = response;
				
                }
              };
              xhttp.open("GET", "php/process.php?process=load_url_mm_dept", true);
              xhttp.send();
		}

		load_hr_dept();
		function load_hr_dept(){
			var xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  var response = this.responseText;
                  document.getElementById("hr_dept_app").innerHTML = response;
				
                }
              };
              xhttp.open("GET", "php/process.php?process=load_url_hr_dept", true);
              xhttp.send();
		}


		function search_url(){
			var keyword = document.getElementById("searchTxt").value;
			var xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  var response = this.responseText;
                  document.querySelector("#searchResult").innerHTML = response;
				
                }
              };
              xhttp.open("GET", "php/process.php?process=search_url&&keyword="+keyword, true);
              xhttp.send();
		}
		startTime();
		function startTime() {
		var today = new Date();
		var h = today.getHours();
		var m = today.getMinutes();
		var s = today.getSeconds();
		m = checkTime(m);
		s = checkTime(s);
		document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
		var t = setTimeout(startTime, 500);
		}
		function checkTime(i) {
		if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
		return i;
		}

		function create_shortcut(){
			
		}
	
	 </script>
	 
</body>
</html>