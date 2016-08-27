<div class='col'>
	<h2>Welcome to Woofer!</h2>
		<p>Woofer is a safe place for dog confessionals or doggie thoughts. We dogs have all done things that we are ashamed of, or perhaps we just need to get something off of our furry chests. If you are an <em>extremely</em> smart dog, or just a very nice person who is typing for their dog, Woofer is the place for you! Everyone is a good dog here! Get to woofing!</p>
		<p><em>Woofer is a very exclusive website. In the interest of the privacy of our Woofers, only <strong>registered, logged-in</strong> doggies can see Woofers and their Woofs.</em></p>
		
		<!-- Dog Bone Image to Go to Sign Up Page  -->
		<div id='SignUp'>
			<a href='/users/signup/'>
				<span class='sign_up_swap'>
					<img src='/images/sign_up.png' alt='Sign Up!'>
				</span>
			</a>
		</div>
</div>

<div class='col'>
		<h2>Log in!</h2>
			
			<!-- Log In Form for existing Woofers  -->
				<form method='POST' action='/users/p_login'>
					
					<p class='label'>Email:</p>
					<input type='text' name='email'><br><br>

					<p class='label'>Password:</p>
					<input type='password' name='password'><br><br>
					
					<p class='error'>	
						<!-- Show error is email is blank  -->		
							<?php if(isset($error) && $error == 'email'): ?>
								Email was blank.

						<!-- Show error is password is blank  -->
							<?php elseif(isset($error) && $error == 'pword'): ?>
								Password was blank.
						
						<!-- Show error is both are blank  -->
							<?php elseif(isset($error) && $error == 'both'): ?>
								Both Email and Password were blank.
						
						<!-- Show error is email is not in proper format  -->
							<?php elseif(isset($error) && $error == 'format'): ?>
								Email not in proper format. 

						<!-- Show if login was rejected -->
							<?php elseif(isset($error) && $error == 'error'): ?>
								Email and password combination was incorrect.
								<br>Try again doggie!
						
							<?php endif; ?>
				</p>

				<input type='submit' name='login' value='Log in'>
			</form>
</div>

