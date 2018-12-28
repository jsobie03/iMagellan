<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<script src="js/index.js"></script> 
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> 

<!--| Script for custom choose file button |-->
<script type="text/javascript">
	$('#chooseFile').bind('change', function () {
		var filename = $("#chooseFile").val();
		if (/^\s*$/.test(filename)) {
			$(".file-upload").removeClass('active');
			$("#noFile").text("No file chosen..."); 
		}
		else {
			$(".file-upload").addClass('active');
			$("#noFile").text(filename.replace("C:\\fakepath\\", "")); 
		}
	});
</script>

<!--| Script for toggle more/less |-->
<script type="text/javascript">
		$("#toggle").click(function() {
			var elem = $("#toggle").text();
			if (elem == "Read More") {
				//Stuff to do when btn is in the read more state
				$("#toggle").text("Cancel");
				$("#text").slideDown();
			} else {
				//Stuff to do when btn is in the read less state
				$("#toggle").text("Update My Info");
				$("#text").slideUp();
			}
		});
</script>

<!--| jQuery MatchHeight Script |-->
<script src="js/jquery.matchHeight.js"></script>
	
	<footer>
      	
		<!---------------| Logo |--------------->
      	<div class="col-md-4 col-md-offset-4 col-xs-6 col-xs-offset-3">
			<a href="index.php"><img id="footLogo" src="images/logo2.png" alt="Second iMagellan Alternate Logo"/></a>
      	</div>
      
		<!---------------| Disclaimer |--------------->
		<div class="col-xs-12">
			<small>This is a fictional site for educational purposes.</small>
		</div>
      </footer>
      </body>
</html>


