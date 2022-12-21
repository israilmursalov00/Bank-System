<?php
	
	if (!Session::isHave("USER_LOGIN")) {
		go("index",0.1);

		die();
	}


?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bank | Payment</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<style type="text/css">
			
		body {
			font-family: sans-serif;
		}

		.container {
			margin-top: 60px;
			padding: 10px;
			background-color: #eee;
			border: 10px;
		}

		.input {
			padding: 25px;
		}

		.input > select,input {
			width: 250px;
			padding: 10px;
			border:2px solid darkorange;
			border-radius: 10px;
			outline: none;
		}

		button[type=button] {
			padding: 10px;
			border: none;
			width: 100px;
			border-radius: 6px;
			background-color: #13a8ce;
			color: white;
			cursor: pointer;
			outline: none;
		} 

		button[type=button]:hover {
			opacity: .4;
		}

		button:disabled {
			opacity: .4;
			cursor: inherit;
		}


	</style>
</head>
<body>
	<div class="container">
		<div class="input">
			<form id="payment_form" method="post">

				<input type="text" name="payment_user_fin" id="payment_user_fin" placeholder="İstifadəçinin FİN kodu"><br><br>
				<input type="number" name="payment_money" id="payment_money" placeholder="Məbləğ">
				<p id="result"></p>
			</form>
			<button type="button" id="mysubmit" onclick="javascript:payment_send();">Ödəniş et</button>
		
		</div>
		
	</div>
	<?php $this->load->view("script/script");?>

	<script type="text/javascript">

	  var SITE_URL = "http://localhost/payment_system/";


		function payment_send(ID) {

			var result = $("#result");
			var mySubmit = $("#mysubmit");

			$("#mysubmit").prop("disabled" ,true);

			mySubmit.html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>');

			$.ajax({
				type:"post",
				url:SITE_URL+"payment_send",
				data:{
					"USER_ID":"<?php echo Session::get('USER_ID');?>",
					"payment_user_fin":$("#payment_user_fin").val(),
					"payment_type":$('#payment_type').val(),
					"payment_money":$("#payment_money").val()
				},
				dataType:"json",
				success:function(data) {
					
					if(data.null) {
						$("#mysubmit").prop("disabled" ,false);
						result.css({
							padding:"10px",
							color:"#d57713",
							marginBottom:"10px",
						});
						result.html(data.null);
						mySubmit.html("Ödəniş et");
					}else if(data.error) {
						$("#mysubmit").prop("disabled" ,false);
							result.css({
								padding:"10px",
								color:"red",
								marginBottom:"10px",
							});	
							result.html(data.error);
							mySubmit.html("Ödəniş et");					
					} else {
						$("#submit").prop("disabled" ,true);
						result.css({
							padding:"10px",
							color:"#10a710",
							marginBottom:"10px",
						});
						result.html(data.success);
						mySubmit.html("Ödəniş et");						
					}
				}
			});			
		}
	</script>
</body>
</html>