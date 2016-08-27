<div class='single_col'>
	<form method='POST' action='/users/signup'>
		
		<!-- Form to sign up new user  -->
			<h2>Sign up!</h2>
			<h3>All Fields Are Required</h3>
				<span class='label'>First Name:</span> <br>
				<input type='text' name='first_name' value='<?=$first_name?>'>
				<br><br>

				<span class='label'>Last Name:</span><br>
				<input type='text' name='last_name' value='<?=$last_name?>'>
				<br><br>

				<span class='label'>Email:</span><br>
				<input type='text' name='email' value='<?=$email?>'>
				<br><br>

				<span class='label'>Password :</span><br>
				<input type='password' name='password' value='<?=$password?>'>
				<br><br>

				<input type='hidden' name='timezone'>

				<script>
	    			$('input[name=timezone]').val(jstz.determine().name());
				</script>	

				<input type='submit' value='Sign up'>	
				<br><br>

				
				<div class='error'>
					<!-- If error with emau=l format display error  -->
						<?php if(isset($error_email)) echo $error_email; ?>	
					
					<!-- Any other error returned display  -->
						<?php if(isset($error)) echo $error; ?>	
				</div>
			
	</form>
</div>



