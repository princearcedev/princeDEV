<?php
	include "conn.php";
	$process_client = $_GET['process'];
	//load users
	if($process_client == 'load_user'){
		echo '
			<tr style="font-weight:bold;">
			
				<td>Name</td>
				<td>Username</td>
				<td>Password</td>
				<td><i class="material-icons">settings</i></td>
			</tr>
			';
		$fetch_user = "SELECT *from admin_account";
		$stmt = $conn->prepare($fetch_user);
		$stmt->execute();
		$result = $stmt->fetchALL();
		if($stmt->rowCount() > 0){
			foreach($result as $user){
				echo '
					<tr>
					
						<td>'.$user["name"].'</td>
						<td>'.$user["username"].'</td>
						<td>'.hash('crc32b',$user["password"]).'</td>
						<td><button class="btn-small red modal-trigger" data-target="del_user_admin" onclick="get_user_id(&quot;'.$user["id"].'*!*'.$user["name"].'&quot;)">delete</button></td>
					</tr>
						';
			}
		}
		//load directories
	}elseif($process_client == 'load_directories'){
		echo '
			<tr style="font-weight:bold;">
				
				<td>System</td>
				<td>URL</td>
				<td>Department</td>
				<td>Date Uploaded</td>
				<td>Uploader</td>
				<td colspan="2"><i class="material-icons">settings</i></td>
			</tr>
			';
		$fetch_user = "SELECT *from directory";
		$stmt = $conn->prepare($fetch_user);
		$stmt->execute();
		$result = $stmt->fetchALL();
		if($stmt->rowCount() > 0){
			foreach($result as $app){
				echo '
					<tr>
						
						<td>'.$app["system"].'</td>
						<td><a href="'.$app["url"].'" target="_blank">'.$app["url"].'</a></td>
						<td>'.$app["department"].'</td>
						<td>'.$app["upload_date"].'</td>
						<td>'.$app["uploader"].'</td>
						<td><button class="btn-small red modal-trigger" data-target="del_url" onclick="get_id_del(&quot;'.$app["id"].'*!*'.$app["system"].'&quot;)"><i class="material-icons">delete</i></button></td>
						<td><button class="btn-small blue modal-trigger" data-target="url_edit_modal" onclick="get_url_edit(&quot;'.$app["id"].'*!*'.$app["system"].'*!*'.$app["url"].'*!*'.$app["department"].'&quot;)"><i class="material-icons">edit</i></button></td>
					</tr>

						';
			}
	}else{
		echo "No records to load.";
		}
		//add url
	}elseif($process_client == 'add_web_url'){
		$id = 0;
		$name = ucwords($_GET['name']);
		$url = $_GET['url_link'];
		$dept = ucwords($_GET['department']);
		$upload_date = date("F j, Y, g:i a");
		$uploader = $_GET['uploader_name'];
		$url_query = "INSERT into directory VALUES ('$id','$name','$url','$dept','$upload_date','$uploader')";
		$stmt = $conn->prepare($url_query);
		if($stmt->execute()){
			
			$id = 0;
			$desc =  $uploader." "."successfully added new web app"." - ".$name;
			$date = date("y")."-".date("m")."-".date("d");
			$sql_report = "INSERT INTO tb_history VALUES('$id','$desc','$date')";
			$stmt = $conn->prepare($sql_report);
			if($stmt->execute()){
				echo "success";
			}
		}else{
			echo "failed";
		}
	
		//del url
	}elseif($process_client == 'delete_url'){
		$delID = $_GET['id'];
		$uploader = $_GET['uploader'];
		$name_sys = $_GET['name'];
		$sql = "DELETE from directory where id = '$delID'";
		$stmt = $conn->prepare($sql);
		if($stmt->execute()){
			$id = 0;
			$desc = $uploader." "."successfully deleted a website "." - ".$name_sys;
			$date = date("y")."-".date("m")."-".date("d");
			$sql_del = "INSERT INTO tb_history VALUES('$id','$desc','$date')";
			$stmt = $conn->prepare($sql_del);
			if($stmt->execute()){
				echo "success";
			}
		}else{
			echo "failed";	
		}

		//add admin
	}elseif($process_client == 'add_admin_sys'){
		$id = 0;
		$moderator = $_GET["moderator"];
		$name = $_GET['name'];
		$name = ucwords($name);
		$username = $_GET['username'];
		$password = $_GET['password'];
		$check_exist = "SELECT username from admin_account where username = '$username'"; //select if provided username is existing
		$stmt = $conn->prepare($check_exist);
		$stmt->execute();
		$result = $stmt->fetchALL(); //dont forget to fetch
		if($stmt->rowCount() > 0){
			echo "exists";
		}else{

		//if rowcount is 0 new admin will added
		$sql_add_admin = "INSERT INTO admin_account VALUES('$id','$name','$username','$password')";
		$stmt = $conn->prepare($sql_add_admin);
			if($stmt->execute()){
				$historyID = 0;
				$notif = $moderator." successfully added ".$name." as an Admin.";
				$date =date("y")."-".date("m")."-".date("d");
				$sql_history_add = "INSERT INTO tb_history VALUES('$id','$notif','$date')";
				$conn->exec($sql_history_add);
				echo "success";
			}else{
				echo "failed";
			}
	}
	//delete user admin
	}elseif($process_client == 'delete_admin'){
		$delUserID =  $_GET['id'];
		$del_mod_admin = $_GET["del_moderator"];
		$del_user_identity = $_GET["name_to_del"];
		$sql_del_user = "DELETE from admin_account where id = '$delUserID'";
		$stmt = $conn->prepare($sql_del_user);
		if($stmt->execute()){
			$idHistory = 0;
			$notif = $del_mod_admin." removed ".$del_user_identity. "as an Admin." ;
			$date = date("y")."-".date("m")."-".date("d");
			$register_del = "INSERT INTO tb_history VALUES ('$idHistory','$notif','$date')";
			$stmt = $conn->prepare($register_del);
			if($stmt->execute()){
				echo "success";
			}
		
		}else{echo 'failed';}


		//load links onto the landing page index.php
	}elseif($process_client == 'load_url_index'){
		$load_user_url = "SELECT system,url,department from directory GROUP BY department";
		$stmt = $conn->prepare($load_user_url);
		$stmt->execute();
		$result = $stmt->fetchALL();
		if($stmt->rowCount() > 0){
			foreach($result as $url){
				echo '
				<div class="col s12 m6">
				<div class="card blue-grey darken-1">
				  <div class="card-content white-text">
					<span class="card-title">'.$url["system"].'</span>
					<span>'.$url["department"].'</span>
					<p></p>
				  </div>
				  <div class="card-action">
					<a href="'.$url["url"].'" target="_blank" class="btn red">Access</a>
					
				  </div>
				</div>
			  </div>
					';
			}
		}
	}
	//update url
	elseif($process_client == 'update_url'){
		$id_to_up = $_GET["id"];
		$new_sys_name = ucwords($_GET["system_name_new"]);
		$url_new_up = $_GET["url_new"];
		$editor = $_GET["editor"];
		$up_dept =  ucwords($_GET['new_dept']);
		$sql_update_url = "UPDATE directory SET system = '$new_sys_name', url = '$url_new_up', uploader = '$editor', department ='$up_dept' where id = '$id_to_up'";
		$stmt = $conn->prepare($sql_update_url);
		if($stmt->execute()){
			$id = 0;
			
			$desc = $editor." "."successfully updated web app named - ".$new_sys_name;
			$date = date("y")."-".date("m")."-".date("d");
			$sql_notif = "INSERT INTO tb_history VALUES('$id','$desc','$date')";
			$conn->exec($sql_notif);
				echo "updated";
			
		}else{
			echo "failed";
		}
		
	}
	// query search for links
	elseif($process_client == 'search_url'){
		$keyword = $_GET['keyword'];
		$query_search = "SELECT *from directory where system LIKE '%$keyword%' OR department LIKE '%$keyword%'";
		$stmt = $conn->prepare($query_search);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if($stmt->rowCount() > 0){
			foreach($result as $sR){
				echo '
					<tr>
						<td>'.$sR["system"].'</td>
						<td>'.$sR["department"].'</td>
						<td><a href="'.$sR["url"].'" target="_blank" class="btn red">Access</a></td>
					</tr>
					  ';
			}
		}else{
			echo "No results";
		}
	}
	//load url all dept
	elseif($process_client == 'load_url_all_dept'){
		$query = "SELECT *from directory where department LIKE '%All Department%'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchALL();
		if($stmt->rowCount() > 0){
			foreach($result as $url){
				echo '
				<div class="col s12 m6 l6">
				<div class="card blue-grey darken-1">
				  <div class="card-content white-text">
					<span class="card-title">'.$url["system"].'</span>
					<span>'.$url["department"].'</span>
					<p></p>
				  </div>
				  <div class="card-action">
					<a href="'.$url["url"].'" target="_blank" class="btn red">Access</a>
					
				  </div>
				</div>
			  </div>
					';
			}
	}
	}
	//load url production dept
	elseif($process_client == 'load_url_prod_dept'){
		$query = "SELECT *from directory where department LIKE '%Production Department%'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchALL();
		if($stmt->rowCount() > 0){
			foreach($result as $url){
				echo '
				<div class="col s12 m6 l6">
				<div class="card blue-grey darken-1">
				  <div class="card-content white-text">
					<span class="card-title">'.$url["system"].'</span>
					<span>'.$url["department"].'</span>
					<p></p>
				  </div>
				  <div class="card-action">
					<a href="'.$url["url"].'" target="_blank" class="btn red">Access</a>
					
				  </div>
				</div>
			  </div>
					';
			}
	}
	}
	//load url mm dept
	elseif($process_client == 'load_url_mm_dept'){
		$query = "SELECT *from directory where department LIKE '%MM Department%'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchALL();
		if($stmt->rowCount() > 0){
			foreach($result as $url){
				echo '
				<div class="col s12 m6 l6">
				<div class="card blue-grey darken-1">
				  <div class="card-content white-text">
					<span class="card-title">'.$url["system"].'</span>
					<span>'.$url["department"].'</span>
					<p></p>
				  </div>
				  <div class="card-action">
					<a href="'.$url["url"].'" target="_blank" class="btn red">Access</a>
					
				  </div>
				</div>
			  </div>
					';
			}
	}else{
		echo "No Record";
	}
	}
	//load url hrga dept
	elseif($process_client == 'load_url_hr_dept'){
		$query = "SELECT *from directory where department LIKE '%HRGA Department%'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchALL();
		if($stmt->rowCount() > 0){
			foreach($result as $url){
				echo '
				<div class="col s12 m6 l6">
				<div class="card blue-grey darken-1">
				  <div class="card-content white-text">
					<span class="card-title">'.$url["system"].'</span>
					<span>'.$url["department"].'</span>
					<p></p>
				  </div>
				  <div class="card-action">
					<a href="'.$url["url"].'" target="_blank" class="btn red">Access</a>
					
				  </div>
				</div>
			  </div>
					';
			}
	}
	}
	//load url it dept
	elseif($process_client == 'load_url_it_dept'){
		$query = "SELECT *from directory where department LIKE '%IT Department%'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchALL();
		if($stmt->rowCount() > 0){
			foreach($result as $url){
				echo '
				<div class="col s12 m6 l6">
				<div class="card blue-grey darken-1">
				  <div class="card-content white-text">
					<span class="card-title">'.$url["system"].'</span>
					<span>'.$url["department"].'</span>
					<p></p>
				  </div>
				  <div class="card-action">
					<a href="'.$url["url"].'" target="_blank" class="btn red">Access</a>
					
				  </div>
				</div>
			  </div>
					';
			}
	}else{
		echo "No Record";
	}
	}
	//load url pe dept
	elseif($process_client == 'load_url_pe_dept'){
		$query = "SELECT *from directory where department LIKE '%PE Department%'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchALL();
		if($stmt->rowCount() > 0){
			foreach($result as $url){
				echo '
				<div class="col s12 m6 l6">
				<div class="card blue-grey darken-1">
				  <div class="card-content white-text">
					<span class="card-title">'.$url["system"].'</span>
					<span>'.$url["department"].'</span>
					<p></p>
				  </div>
				  <div class="card-action">
					<a href="'.$url["url"].'" target="_blank" class="btn red">Access</a>
					
				  </div>
				</div>
			  </div>
					';
			}
	}else{
		echo "No Record";
	}
	}
	//load url eqd dept
	elseif($process_client == 'load_url_eqd_dept'){
		$query = "SELECT *from directory where department LIKE '%EQD Department%'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchALL();
		if($stmt->rowCount() > 0){
			foreach($result as $url){
				echo '
				<div class="col s12 m6 l6">
				<div class="card blue-grey darken-1">
				  <div class="card-content white-text">
					<span class="card-title">'.$url["system"].'</span>
					<span>'.$url["department"].'</span>
					<p></p>
				  </div>
				  <div class="card-action">
					<a href="'.$url["url"].'" target="_blank" class="btn red">Access</a>
					
				  </div>
				</div>
			  </div>
					';
			}
	}else{
		echo "No Record";
	}
	}
	//load history
	elseif($process_client == 'load_history'){
		$fetch_history = "SELECT description,notif_date from tb_history order by id DESC";
		$stmt = $conn->prepare($fetch_history);
		$stmt->execute();
		$result = $stmt->fetchALL();
		if($stmt->rowCount() > 0){
			foreach($result as $h){
				echo '
						<tr>
							<td>'.$h["description"].'</td>
							<td>'.$h["notif_date"].'</td>
						</tr>
					';
			}
		}else{
			echo "NO RECORD";
		}
	}
?>