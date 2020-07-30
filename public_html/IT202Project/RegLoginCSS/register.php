<?php include("header.php");?>
<h4>Register</h4>
<form method="POST">
	<label for="email">Email
	<input type="email" id="email" name="email" autocomplete="off" />
	</label>	
	<label for="fn">First Name
	<input type="text" id="fn" name="First_Name" autocomplete="off"/>
	</label>
	<label for="ln">Last Name
	<input type="text" id="ln" name="Last_Name" autocomplete="off"/>
	</label><br>
	<label for="p">Password
	<input type="password" id="p" name="password" autocomplete="off"/>
	</label>
	<label for="cp">Confirm Password
	<input type="password" id="cp" name="cpassword"/>
	</label>
	<input type="submit" name="register" value="Register"/>
</form>
<?php
if(isset($_POST["register"])){
	if(isset($_POST["password"]) && isset($_POST["First_Name"]) && isset($_POST["Last_Name"]) && isset($_POST["cpassword"]) && isset($_POST["email"])){
		$password = $_POST["password"];
		$cpassword = $_POST["cpassword"];
		$email = $_POST["email"];
		$Lname= $_POST["Last_Name"];
		$Fname= $_POST["First_Name"];	
		if($password == $cpassword){
			$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
			try{
				$db = new PDO($connection_string, $dbuser, $dbpass);
				$hash = password_hash($password, PASSWORD_BCRYPT);
				
				$stmt = $db->prepare("INSERT INTO User (email, First_name, Last_name, password) VALUES(:email, :Fname, :Lname, :password)");
				$stmt->execute(array(
					":email" => $email,
					":Fname" => $Fname,
					":Lname" => $Lname,
					":password" => $hash//Don't save the raw password $password
				));
				
				$e = $stmt->errorInfo();
				if($e[0] != "00000"){
					echo var_export($e, true);
				}
				else{
					echo "<div>Successfully registered!</div>";
				}
			}
			catch (Exception $e){
				echo $e->getMessage();
			}
		}
		else{
			echo "<div>Passwords don't match</div>";
		}
	}
}
?>
