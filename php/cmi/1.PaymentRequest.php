<html>

<head>

<title>3D PAY HOSTING</title>

<meta http-equiv="Content-Language" content="tr">


<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-9">


<meta http-equiv="Pragma" content="no-cache">


<meta http-equiv="Expires" content="now">


</head>


<body>

	<?php
	session_start();
	require_once '../config.php';
	$id=$_SESSION['id_cl'];
	$sql="SELECT * FROM client,log WHERE client.id_cl='".$id."'
and client.id_cl=log.id_cl";
$res=mysqli_query($db,$sql);
$row=mysqli_fetch_assoc($res);
	
		$orgClientId  = "600002511";
  		$orgAmount = $_GET['total_amount'] ?? "0";
		// echo "Amount: " . $orgAmount;
  		$orgOkUrl =  "";
  		$orgFailUrl = "";
  		$shopurl = "";
  		$orgTransactionType = "PreAuth";
  		$orgRnd =  microtime();
  		$orgCallbackUrl = "";
  		$orgCurrency = "504";
		
	?>


	<center>

		<form method="post" action="2.SendData.php">
			<table>
				<tr>

					<td align="center" colspan="2"><input type="submit"
						value="Complete Payment" id="submit"/></td>
				</tr>

			</table>

				<input type="hidden" name="clientid" value="<?php echo $orgClientId ?>"> 
				<input type="hidden" name="amount" value="<?php echo $orgAmount ?>">
				<input type="hidden" name="okUrl" value="<?php echo $orgOkUrl ?>">
				<input type="hidden" name="failUrl" value="<?php echo $orgFailUrl ?>">
				<input type="hidden" name="TranType" value="<?php echo $orgTransactionType ?>">
				<input type="hidden" name="callbackUrl" value="<?php echo $orgCallbackUrl ?>">
				<input type="hidden" name="shopurl" value="<?php echo $shopurl ?>">
				<input type="hidden" name="currency" value="<?php echo $orgCurrency ?>">
				<input type="hidden" name="rnd" value="<?php echo $orgRnd ?>">
				<input type="hidden" name="storetype" value="3D_PAY_HOSTING">
				<input type="hidden" name="hashAlgorithm" value="ver3">
				<input type="hidden" name="lang" value="fr">
				<input type="hidden" name="refreshtime" value="5">
				<input type="hidden" name="BillToName" value="<?php echo $row['nom_cl'] ?>">
				<input type="hidden" name="BillToCompany" value="billToCompany">
				<input type="hidden" name="BillToStreet1" value="<?php echo $row['adresse'] ?>">
				<input type="hidden" name="BillToCity" value="casablanca">
				<input type="hidden" name="BillToStateProv" value="Maarif Casablanca">
				<input type="hidden" name="BillToPostalCode" value="20230">
				<input type="hidden" name="BillToCountry" value="504">
				<input type="hidden" name="email" value="<?php echo $row['email'] ?>">
				<input type="hidden" name="tel" value="<?php echo $row['tel'] ?>">
				<input type="hidden" name="encoding" value="UTF-8">
				<input type="hidden" name="oid" value="1234ABC"> <!-- La valeur du paramètre oid doit être unique par transaction -->
				
		</form>

	</center>


	<script>
		// Get a reference to the button element
const button = document.getElementById('submit');

// Programmatically trigger a click on the button
button.click();

	</script>
</body>

</html>
