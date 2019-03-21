<?php 
session_start();
if (!isset($_SESSION["loket_client"])) {
	$_SESSION["loket_client"] = NULL;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Admin : Queue</title>
	<link href="../assert/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assert/css/jumbotron-narrow.css" rel="stylesheet">
	<script src="../assert/js/jquery.min.js"></script>
	<script src="js/recta.js"></script>

	<meta charset="utf-8" name="recta-key" value="7576429989">
	<meta charset="utf-8" name="recta-port" value="1811">
</head>
<body>
	<div class="container">
		<form>
			<div class="jumbotron">
				<h1 class="next">
					<span class="glyphicon glyphicon-book"></span>
				</h1>
				<button type="button" class="btn btn-primary next_getway">Next <span class="glyphicon glyphicon-chevron-right"></span></button>
			</div>
		</form>
		<br/>
		<footer class="footer">
			<p>&copy; <?php echo date("Y");?></p>
		</footer>
	</div>
</body>
<script type="text/javascript">
	$("document").ready(function()
	{
		let key = $("[name=recta-key]").attr("value");
		let port = $("[name=recta-port]").attr("value");

		var printer = new Recta(key, port);

		function decimalToHexString(number)
		{
			if (number < 0)
			{
				number = 0xFFFFFFFF + number + 1;
			}

			return number.toString(16).toUpperCase();
		}
		function ascii_to_hexa(str)
		{
			str = str.toString();
			var arr1 = [];
			for (var n = 0, l = str.length; n < l; n ++) 
			{
				var hex = Number(str.charCodeAt(n)).toString(16);
				arr1.push(hex);
			}
			return arr1.join('');
		}

		function cetak(no){
			const cstart = "\x1b\x21\x00\x1d\x21\x77";
			const cend = "\x0a\x1d\x56\x41\x03";
			let no_hex = ascii_to_hexa(no);

			printer.open().then(function () {
				printer.align('center')
				.raw(cstart+no)
				.feed(7)
				.cut()
				.print();
			});
		}

		// GET LAST COUNTER
		$.post( "../apps/admin_getway.php", function( data ) {
			$(".next").html(data['next']);
		},"json");
		

	    // RESET 
	    $(".next_getway").click(function(){
	    	var next_current = $(".next").text();
	    	$.post( "../apps/admin_getway.php", {"next_current": next_current}, function( data ) {
	    		$(".next").html(data['next']);

	    		cetak(data['next']);
	    	},"json");
	    });

	});
</script>
</html>

