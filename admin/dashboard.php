<?php
	require "../php/session.php";
	require "../php/conn.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Web App Redirector | <?=$name;?></title>
	<link rel="icon" href="assets/WR_LOGO.ico" type="image/gif" sizes="16x16">
	<link rel="stylesheet" type="text/css" href="../node_modules/materialize-css/dist/css/materialize.min.css"/>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,500;0,600;1,500&display=swap" rel="stylesheet">
	<style type="text/css">
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
		background-color: darkgrey;
		outline: 1px solid slategrey;
		}
	
		
	</style>
</head>
<body>
		
	    <nav class="black nav-extended">
	      <div class="nav-wrapper">
	        <a><i class="material-icons left">donut_large</i>Web App Redirector ver 2.0 - <?=$name;?></a>

	        <ul class="right">
				<li><li><div id="time"></div></li></li>
	          <li><a data-target="login_form" class="modal-trigger tooltipped" data-tooltip="Logout" data-position="left"><i class="material-icons">power_settings_new</i></a></li>
	        </ul>
	      </div>
	      <div class="nav-content">
	      	 <ul class="tabs tabs-transparent">
	  		<li class="tab"><a href="#tab1" ondblclick="refresh_url()">Web App Directories</a></li>
	  		<li class="tab"><a href="#tab2" ondblclick="refresh_user()">Authorized Admin Users</a></li>
	  		<li class="tab"><a href="#tab3" ondblclick="refresh_history()">History Logs</a></li>
	  	</ul>
	      </div>
	    </nav>

	  

	  <div class="row">
	  	<!--tab1-->
	  	<div class="row col s12" id="tab1">
				  <div class="col s12 l12" style="margin-top:1%;">
					<div class="col s12 l1"><a data-target="add_url" class="btn-large red modal-trigger" ><i class="material-icons">add</i></a></div>
				  	<div class="col s12 l11"><div class="input-field"><input type="text" id="url_search"><label>Search</label></div>
				</div>
				</div>
			  <!--tab1 content-->
	  		<table id="webapp_record"></table>
	  	</div>

	  	<!--tab2-->
	  	<div class="col s12" id="tab2">
	  		<table class="container" id="user_record"></table>
	  		<!--floating button-->
	  		<div class="fixed-action-btn">
	  			<a class="btn-floating btn-large red modal-trigger" data-target="add_admin"><i class="material-icons">account_circle</i></a>
	  		</div>
	  	</div>
	  	<!--tab3-->
	  	<div class="row col s12" id="tab3">
				<div class="container col s12 input-field">
					<input type="text" id="history_search" placeholder="Type date, name or action">
				</div>
			  <table class="container" id="history_record"></table>
		  </div>
	  </div>

	  <!--modal logout-->
	 <div class="modal bottom-sheet" id="login_form">
	 	<div class="modal-content">
	 		<form class="row" method="POST">
	 			<div class="input-field col s12">
	 				<input type="submit" class="btn-large black right" name="logout_btn" value="Logout">
	 			</div>
	 		</form>
	 	</div>
	 </div>

	
	 <!--modal add url-->
	 <div class="modal" id="add_url">
	 	<div class="modal-content">
	 		<div class="row">
			 
			<!-- URL INFO START HERE -->
		
	 			<div class="input-field col s12">
	 				<input type="hidden" id="uploader" value="<?=$name;?>">
	 			</div>

	 			<div class="input-field col s12">
	 				<input type="text" id="system_name"><label id="label_sys_name">System Name</label>
	 			</div>

	 			<div class="input-field col s12">
	 				<input type="text" id="url"><label id="label_url">URL</label>
	 			</div>
				
				 <div class="input-field col s12">
					
					 <input type="text" id="department"><label id="label_dept">Department</label>
	 			</div>
				 
	 			<div class="input-field col s12">
	 				<button class="btn-large green" onclick="add_web_app()"  id="add_url_btn">Save</button>
	 				<button class="btn-large red modal-close">Cancel</button>
	 			</div>
	 		</div>
	 	</div>
	 </div>

	 <!--modal delete url-->
	 <div class="modal" id="del_url">
	 	<div class="modal-content">
			 <input type="hidden" id="del_id_demo">
			 <input type="hidden" id="del_sys_demo">
	 		<h3 class="center flow-text">Are you sure you want to delete?</h3>
	 		
	 	</div>
	 	<div class="modal-footer">
	 		<button class="btn red" onclick="del_url()">Confirm Delete</button>
	 		<button class="modal-close btn-flat">Cancel</button>
	 	</div>
	</div>


	<!--modal delete user-->
	 <div class="modal" id="del_user_admin">
	 	
	 	<div class="modal-content">
		 	<input type="text" value="<?=$name;?>" id="del_moderator_admin">
			 <input type="hidden" id="del_id_user">
			 <input type="text" id="del_name_user">
	 		<h3 class="center flow-text">Are you sure you want to delete this admin?</h3>
	 		
	 	</div>
	 	<div class="modal-footer">
	 		<button class="btn red" onclick="del_user()">Confirm Delete</button>
	 		<button class="modal-close btn-flat">Cancel</button>
	 	</div>
	</div>


	<!--modal add user-->
	<div class="modal modal-fixed-footer" id="add_admin">
		<div class="modal-content">
			<div class="row">
				<div class="col s12 center">Add Admin</div>
				<input type="hidden" value="<?=$name;?>" id="admin_action_del"/>
				<div class="col s12 input-field">
					<input type="text" id="name_of_user"><label id="label_name_user">Name</label>
				</div>

				<div class="col s12 input-field">
					<input type="text" id="username_admin"><label id="label_username_admin">Username</label>
				</div>

				<div class="col s12 input-field">
					<input type="password" id="password_admin"><label id="label_pass_admin">Password</label>
					<i class="material-icons prefix" style="right:0;cursor:pointer;" onclick="show_pass()" id="show">remove_red_eye</i>
				</div>

				
			</div>
		</div>
				<div class="modal-footer">
					<button class="btn red" onclick="add_admin_btn()" id="add_admin_btn">Add</button>
					<button class="btn-flat modal-close">Cancel</button>
				</div>
	</div>	 	
	 </div>

	<!--modal edit url-->
		<div class="modal modal-fixed-footer" id="url_edit_modal">
			<div class="modal-content">
				<div class="row">
					<div class="input-field">
						<input type="hidden" id="edit_id_get">
					</div>
					<div class="input-field">
						<input type="hidden" id="name_editor" value="<?=$name;?>">
					</div>
					<!-- input sys name -->
					<div id="label_edit_sys_name">System's Name</div>
					
					<div class="input-field">
						<input type="text" id="edit_system_name">
					</div>
					<!-- label and input url -->
					<div id="label_edit_url">URL</div>
					<div class="input-field">
						<input type="text" id="edit_url">
					</div>

					<!-- label and input department -->
					<div id="label_edit_department"></div>
					<div class="input-field">
						<input type="text" id="edit_dept" disabled>
						<i class="material-icons prefix" style="right:0;cursor:pointer;" id="en_btn" onclick="enable_dept_input()">add</i>
						<i class="material-icons prefix" style="right:0;cursor:pointer;display:none;" id="dis_btn" onclick="disable_dept_input()">close</i>
					</div>
					
				</div>
			</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button class="btn blue" onclick="update_url()" id="update_url_btn">Update</button>
					<button class="btn-flat modal-close">Cancel</button>
				</div>
		</div>
	 <!--javascript-->
	<script type="text/javascript" src="../node_modules/materialize-css/dist/js/jquery.min.js"></script>
 	<script type="text/javascript" src="../node_modules/materialize-css/dist/js/materialize.min.js"></script>
	 <!--javascript for front end  -->
	 <script type="text/javascript">
 		$(document).ready(function(){
 			$('.tooltipped').tooltip();
 			$('.tabs').tabs();
 			$('.modal').modal();
 		});
	 </script>
	 <!-- javascript for functions ajax -->
	 <script type="text/javascript">
		//select dept cheng inoput on select change
		function select_dept(){
			var x = document.getElementById("edit_department").value;
			document.getElementById("edit_dept").value = x;
		}
 		//load user table
 		load_users();
     	 function load_users(){
             var xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  var response = this.responseText;
                  document.getElementById("user_record").innerHTML = response;
                 
                }
              };
              xhttp.open("GET", "../php/process.php?process=load_user", true);
              xhttp.send();
          }	
		  //refresh web url

		  function refresh_url(){
			  load_directories();
			  M.toast({html:'URL successfully refreshed.', classes:'rounded'});
		  }

		  //refresh user

		  function refresh_user(){
			  load_users();
			  M.toast({html:'List successfully refreshed.', classes:'rounded'});
		  }

		  //refresh history
		  function refresh_history(){
			  load_history();
			  M.toast({html:'History successfully refreshed', classes:'rounded'});
		  }

          //load web app links
          load_directories()

          	function load_directories(){
          	var xhttp = new XMLHttpRequest();
          	xhttp.onreadystatechange = function(){
          		if(this.readyState == 4 && this.status == 200){
          			var response = this.responseText;
          			document.getElementById("webapp_record").innerHTML = response;
          		}
          	};
          	xhttp.open("GET","../php/process.php?process=load_directories",true);
          	xhttp.send();
          }
 	
		 load_history();
		 function load_history(){
			var xhttp = new XMLHttpRequest();
          	xhttp.onreadystatechange = function(){
          		if(this.readyState == 4 && this.status == 200){
          			var response = this.responseText;
          			document.getElementById("history_record").innerHTML = response;
          		}
          	};
          	xhttp.open("GET","../php/process.php?process=load_history",true);
          	xhttp.send();
		 }
		 //add url
 		function add_web_app(){
          	var name = document.getElementById("system_name").value;
          	var url = document.getElementById("url").value;
			var dept = document.getElementById("department").value;
          	var uploader = document.getElementById("uploader").value;
          	if(name === ''){
          		document.getElementById("label_sys_name").innerHTML = "System Name is required.";
          		document.getElementById("label_sys_name").style.color = "red";
          	}else if(url === ''){
          		document.getElementById("label_url").innerHTML = "System's URL is required.";
          		document.getElementById("label_url").style.color = "red";
          	}else if(dept === ''){
				document.querySelector("#label_dept").innerHTML = "Department is required.";
				document.querySelector("#label_dept").style.color ="red";
			  }
			  else{
				  	document.getElementById("add_url_btn").disabled = true;
          			var xhttp = new XMLHttpRequest();
				    xhttp.onreadystatechange = function(){
				    if(this.readyState == 4 && this.status == 200){
				    var response = this.responseText;
				    if(response === 'success'){
				    	load_directories();
						load_history();
				    	clear_url();
				    	M.toast({html:'SUCCESSFULLY ADDED WEB APP URL',classes: 'rounded'});
						document.getElementById("add_url_btn").disabled = false;
						$('.modal').modal('close','#add_url');
				    }
				   }
				 };
			xhttp.open("GET","../php/process.php?process=add_web_url&&name="+name+"&&url_link="+url+"&&uploader_name="+uploader+"&&department="+dept,true);
			xhttp.send();
          	}
          }
 	
 		//delete functions
 		function get_id_del(param){ 
 			
 			var string =  param.split("*!*");
			var id = string[0];
			var system_name = string[1];
			document.getElementById("del_id_demo").value = id;
			document.getElementById("del_sys_demo").value = system_name;
			
 		}

 		function del_url(){
				var uploader = document.getElementById("uploader").value;
				var system_desc = document.getElementById("del_sys_demo").value;
 				var id = document.getElementById("del_id_demo").value;
 				var xhttp = new XMLHttpRequest();
				    xhttp.onreadystatechange = function(){
				    if(this.readyState == 4 && this.status == 200){
				    var response = this.responseText;
				    if(response === 'success'){
				    	M.toast({html:'DELETED SUCCESSFULLY', classes:'rounded'});
				    	$('.modal').modal('close','#del_url');
						load_directories();
						load_history();
				    }	
				   }
				 };
			xhttp.open("GET","../php/process.php?process=delete_url&&id="+id+"&&uploader="+uploader+"&&name="+system_desc,true);
			xhttp.send();
 			}
 		//get id of user to del
 		function get_user_id(param){
			var string  = param.split("*!*");
			var id  = string[0];
			var del_name = string[1];
 			document.querySelector("#del_id_user").value = id;
			document.querySelector("#del_name_user").value = del_name;
 			
 		}
 		//del user func
 		function del_user(){
 				var id = document.getElementById("del_id_user").value;
				var del_moderator = document.getElementById("del_moderator_admin").value;
				var del_user_name = document.getElementById("del_name_user").value;
 				var xhttp = new XMLHttpRequest();
				    xhttp.onreadystatechange = function(){
				    if(this.readyState == 4 && this.status == 200){
				    var response = this.responseText;
				    if(response === 'success'){
				    	M.toast({html:'DELETED SUCCESSFULLY', classes:'rounded'});
				    	$('.modal').modal('close','#del_user_admin');
						load_users();
						load_history();
				    }else{
				    	M.toast({html:'FAILED'});
				    	$('.modal').modal('close','#del_user_admin');
				    }
				   }
				 };
			xhttp.open("GET","../php/process.php?process=delete_admin&&id="+id+"&&del_moderator="+del_moderator+"&&name_to_del="+del_user_name,true);
			xhttp.send();
 			}



 		//clearing fields for url
 		function clear_url(){
 			document.getElementById("system_name").value = '';
 			document.getElementById("url").value = '';
			document.getElementById("department").value = '';
			 
 		}

 		function clear_admin_input(){
 			document.querySelector("#name_of_user").value = '';
 			document.querySelector("#username_admin").value = '';
 			document.querySelector("#password_admin").value	= '';
 		}
 		//add admin
 		function add_admin_btn(){
 			var name_admin = document.getElementById("name_of_user").value;
 			var username_admin = document.getElementById("username_admin").value;
 			var password_admin = document.getElementById("password_admin").value;
			var moderator = document.getElementById("admin_action_del").value;
 			if(name_admin === ''){
 				document.querySelector("#label_name_user").innerHTML = "Name is require";
 				document.querySelector("#label_name_user").style.color = "red";
 			}else if(username_admin === ''){
 				document.querySelector("#label_username_admin").innerHTML = "Username must provided";
 				document.querySelector("#label_username_admin").style.color = "red";
 			}else if(password_admin === ''){
 				document.querySelector("#label_pass_admin").innerHTML = "Password must provided";
 				document.querySelector("#label_pass_admin").style.color = "red";
 			}else{
				document.getElementById("add_admin_btn").disabled = true;
 				var xhttp = new XMLHttpRequest();
				    xhttp.onreadystatechange = function(){
				    if(this.readyState == 4 && this.status == 200){
				    var response = this.responseText;
				    if(response === 'success'){
						document.getElementById("add_admin_btn").disabled = false;
				    	M.toast({html:'SUCCESSFULLY ADDED NEW ADMIN',classes: 'rounded'});
						$('.modal').modal('close','#add_admin');
				    	clear_admin_input();
						load_users();
						load_history();
				    }else if(response === 'exists'){
						document.getElementById("add_admin_btn").disabled = false;
				    	M.toast({html:'USERNAME ALREADY EXISTS',classes: 'rounded'});
						load_users();
						
				    }
				   }
				 };
			xhttp.open("GET","../php/process.php?process=add_admin_sys&&name="+name_admin+"&&username="+username_admin+"&&password="+password_admin+"&&moderator="+moderator,true);
			xhttp.send();
 			}
 		}
 		//showing password
 		function show_pass(){
 			var x = document.getElementById("password_admin");
 				if(x.type === "password"){
 					x.type = "text";
 					document.getElementById("show").style.color ="red";

 				}else{
 					x.type = "password";
 					document.getElementById("show").style.color ="";
 				}
 		}

		//fetch individual data via param
		function get_url_edit(param){
			var str =  param.split("*!*");
			var id = str[0];
			var system_name = str[1];
			var url = str[2];
			var department = str[3];
			 
			document.getElementById("edit_id_get").value = id;
			document.getElementById("edit_system_name").value = system_name;
			document.getElementById("edit_url").value = url;
			document.getElementById("edit_dept").value = department; 
		}
		// enable input 
		function enable_dept_input(){
			document.getElementById("edit_dept").disabled = false;
			document.getElementById("en_btn").style.display = "none";
			document.getElementById("dis_btn").style.display = "block";
		}
		function disable_dept_input(){
			document.getElementById("edit_dept").disabled = true;
			document.getElementById("en_btn").style.display = "block";
			document.getElementById("dis_btn").style.display = "none";
		}
		//update url
		function update_url(){
			var id = document.querySelector("#edit_id_get").value;
			var system_name_up = document.querySelector("#edit_system_name").value;
			var url_up = document.querySelector("#edit_url").value;	
			var up_dept = document.querySelector("#edit_dept").value;
			var editor_name = document.querySelector("#name_editor").value;
			if(system_name_up === ''){
				document.querySelector("#label_edit_sys_name").innerHTML = "System name is required.";
				document.querySelector("#label_edit_sys_name").style.color = "red";
			}else if(url_up === ''){
				document.querySelector("#label_edit_url").innerHTML = "Web App URL must provided.";
				document.querySelector("#label_edit_url").style.color = "red";
			}else{
				document.getElementById("update_url_btn").disabled = true;
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
					var response = this.responseText;
					if(response === 'updated'){
						M.toast({html:'SUCCESSFULLY UPDATED'});
						disable_dept_input();
						document.getElementById("update_url_btn").disabled = false;
						$('.modal').modal('close','#url_edit_modal');
						load_directories();
						load_history();
					}else{
						disable_dept_input();
						document.getElementById("update_url_btn").disabled = false;
						M.toast({html:'UPDATE FAILED, DUE TO NETWORK ERROR',classes:'rounded'})
					}
					
					}
				};
              xhttp.open("GET", "../php/process.php?process=update_url&&id="+id+"&&system_name_new="+system_name_up+"&&url_new="+url_up+"&&editor="+editor_name+"&&new_dept="+up_dept, true);
              xhttp.send();
			}
			}

		$(document).ready(function(){
		$("#url_search").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#webapp_record tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
		});

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
		
		//search history
		
		$(document).ready(function(){
		$("#history_search").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#history_record tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
		});
</script>
</body>
</html>
