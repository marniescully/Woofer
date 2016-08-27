<div class='single_col'>
	
	<!-- A form to edit profile  -->
		<form method='POST' enctype="multipart/form-data" action='/users/edit_profile'>
			<h2>Edit Your Profile <?=$user->first_name?></h2>
			<h3>All Fields Are Required</h3>
				<span class='label'>First Name:</span><br>
				<input type='text' name='first_name' value='<?=$first_name?>'>
				<br><br>

				<span class='label'>Last Name:</span><br>
				<input type='text' name='last_name' value='<?=$last_name?>'>
				<br><br>

				<span class='label'>Age (in people years) :</span><br>
				<input type='text' name='age' value='<?=$age?>'>
				<br><br>

				<span class='label'>Email:</span><br>
				<input type='text' name='email' value='<?=$email?>'>
				<br><br>

				<span class='label'>Location:</span><br>
				<input type='text' name='location' value='<?=$location?>'>
				<br><br>

				<span class='label'>Bio:</span><br>
				<textarea name='bio' placeholder='150 Characters Max'><?=$bio?></textarea>
			    <br><br>

			    <span class='label'>Picture:</span><br>
				<input type='file' name='avatar'>
				<br><br>

				<input type='submit' name='submit' value='Save Changes'>
				<input type='submit' name='submit' value='Cancel'>

				<div class='error'>
					<!-- If error with emau=l format display error  -->
						<?php if(isset($error_email)) echo $error_email; ?>	
					
					<!-- Any other error returned display  -->
						<?php if(isset($error)) echo $error; ?>	
				</div>
		</form>
</div>