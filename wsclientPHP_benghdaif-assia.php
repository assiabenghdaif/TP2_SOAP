<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>wsclientPHP_benghdaif-assia</title>

	<style>
		body {font-family: Arial, Helvetica, sans-serif;}
		* {box-sizing: border-box;}



		/* The popup form - hidden by default */
		.form-popup {
		display: none;
		position: fixed;
		/* bottom: 0;
		right: 15px; */
		border: 3px solid #f1f1f1;
		z-index: 9;
		}

		/* Add styles to the form container */
		.form-container {
		max-width: 300px;
		padding: 10px;
		background-color: white;
		}

		/* Full-width input fields */
		.form-container input[type=text], .form-container input[type=password] {
		width: 100%;
		padding: 15px;
		margin: 5px 0 22px 0;
		border: none;
		background: #f1f1f1;
		}

		/* When the inputs get focus, do something */
		.form-container input[type=text]:focus, .form-container input[type=password]:focus {
		background-color: #ddd;
		outline: none;
		}

		/* Set a style for the submit/login button */
		.form-container .btn {
		background-color: #04AA6D;
		color: white;
		padding: 16px 20px;
		border: none;
		cursor: pointer;
		width: 100%;
		margin-bottom:10px;
		opacity: 0.8;
		}

		/* Add a red background color to the cancel button */
		.form-container .cancel {
		background-color: red;
		}

		/* Add some hover effects to buttons */
		.form-container .btn:hover, .open-button:hover {
		opacity: 1;
		}
			
		.button {
			display: inline-block;
			background-color: #555;
			color: white;
			padding: 16px 20px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			cursor: pointer;
			width: 280px; 
		}

		.div {
		text-align: center;
		}
		table,th,td{
			border:1px solid black;
			margin: 20pt auto;
			text-align: center;
			height: 30pt;

		}

		th{
			
			width: 80pt
		}

	</style>
</head>
<body>
<?php
	$client = new SoapClient('http://localhost:2001/BanqueWS?wsdl');
	$param=new stdClass();
	$resultat=0;
	if (isset($_POST['amount']) ) 
	{
		$amount=$_POST['amount'];
		$param->amount=$amount;
		$res=$client->__soapCall("Convert",array($param));
		//var_dump($res);
		$resultat=$res->return;
		
	}
	$param2=new stdClass();
	$code=0;
	$solde=0;
	if (isset($_POST['code']) ) 
	{
		$code=$_POST['code'];
		$param2->code=$code;
		$res2=$client->__soapCall("getCompte",array($param2));
		//var_dump($res2);
		$code=$res2->return->code;
		$solde=$res2->return->solde;
	}
	// $res3=$client->__soapCall("allComptes",array());
	// //var_dump($res3);
	// echo ("<hr/>");
	// foreach($res3->return as $cpte){
	// 	echo("Code=".$cpte->code);
	// 	echo("<br/>Solde=".$cpte->solde);
	// 	echo("<br/>");
	// }
?>






	<div class="div">
		<button class="button" onclick="openForm()">Convert amount</button>
		
		<button class="button" onclick="openFormget()">Get Compte</button>
		<button class="button" onclick="openFormall()">Get All Comptes</button>
		
	</div>
	<div class="form-popup" id="myForm">
	<form method="post" class="form-container" onsubmit="convert()">
        <div >
          <label for="amount">amount</label>
          <input type="text" name="amount" id="amount" >
        </div>
        <div >
          <input type="submit" class="btn"  value="Convert"  >
		  <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
	
        </div>
		
      </form>
	  <div id="showConvert">
	  	
	  </div>
	</div>


	<div class="form-popup" id="myFormget">
		<form method="post" class="form-container" onsubmit="get()">
			<div >
			<label for="code">code</label>
			<input type="text" name="code" id="code" >
			</div>
			<div >
			<input type="submit" class="btn"  value="get"  >
			<button type="button" class="btn cancel" onclick="closeFormget()">Close</button>
		
			</div>
			
		</form>
		<div id="showgetCompte">
			
		</div>
	</div>

	<div class="form-popup" id="myFormall">
		<?php
			$res3=$client->__soapCall("allComptes",array());
			
		?>
		<table >
			<tr >
			<th>Compte Code </th>
			<th>Solde</th>
			</tr>
			<?php foreach($res3->return as $cpte){ ?>
				<tr>
					<td><?php echo $cpte->code; ?></td>
					<td><?php echo $cpte->solde; ?></td>
				</tr>
			
			<?php }; ?>
      </table>
	  <form class="form-container" > <div>
	  <button type="button" class="btn cancel" onclick="closeFormall()">Close</button>
		</div></form>
	</div>

	<script>
		function openForm() {
			document.getElementById("myForm").style.display = "block";
		}

		

		function closeForm() {
		document.getElementById("myForm").style.display = "none";
		}

		function openFormget() {
			document.getElementById("myFormget").style.display = "block";
		}

		function closeFormget() {
		document.getElementById("myFormget").style.display = "none";
		}

		function openFormall() {
			document.getElementById("myFormall").style.display = "block";
		}

		function closeFormall() {
		document.getElementById("myFormall").style.display = "none";
		}

		function convert() {
			showConvert=document.getElementById("showConvert");
			amount=document.getElementById("amount").value;
			const para = document.createElement("p");
			para.innerHTML =amount+" euro est "+<?php echo($resultat)?>+" DHs" ;
			showConvert.appendChild(para);
			
		}

		function get(){
			showgetCompte=document.getElementById("showgetCompte");
			code=document.getElementById("code").value;
			const para = document.createElement("p");
			para.innerHTML ="Compte code="+<?php echo($code)?>+", Compte solde="+<?php echo($solde)?>+" DHs" ;
			showgetCompte.appendChild(para);

		}
	</script>
</body>
</html>