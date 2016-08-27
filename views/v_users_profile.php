
<div class='col' id="Profile_text">
	<h1><?=$user->first_name?>'s Profile</h1>
	<div id='bio'>
	    <p><span class='label'> First Name:</span> <?=$user->first_name?></p>
	    <p><span class='label'> Last Name:</span> <?=$user->last_name?></p>
	    <p><span class='label'> Age (In People Years):</span> <?=$user->age?></p>
	    <p><span class='label'> Email:</span> <?=$user->email?></p>
	    <p><span class='label'> Location:</span> <?=$user->location?></p>
	    <p><span class='label'> Bio:</span> <?=$user->bio?></p>
	
	<!-- Display the Woofer's avatar  -->
		<?php if(isset($avatar)) : ?>
			<img src='<?=$user->avatar?>' alt='avatar'>
		<?php endif; ?>
	</div>

	<!-- Pretty red bones as a hr  -->
	<div class='profile_rule'>
		&nbsp;
	</div>
</div>
<div class='col'> 
	<!-- Block of bone graphics as menu  -->
	<div id='bone_buttons'>		
		<div class='bone'>
			<a href='/users/edit_profile/'>
				<span class='profile_swap'>
					<img src='/images/profile.png' alt='Edit Profile!'>
	    	 	</span>
	    	 </a>
		</div>
		<div class='bone'>
			<a href='/posts/add'>
				<span class='woof_swap'> 
					<img src='/images/woof.png' alt='Woof!'>
				</span>
			</a>
		</div>
		<div class='bone'>
		   	<a href='/posts/index'>
			   	<span class='woofs_swap'>
		    		<img src='/images/woofs.png' alt='Woofs'>
		    	</span>
			</a>
		</div>
		<div class='bone'>
		    <a href='/posts/users'>
		    	<span class='woofers_swap'> 
		    		<img src='/images/woofers.png' alt='Woofers'>
		    	</span>
			</a> 
		</div>
	</div>
	<div id='Woofs'>
	<!-- If Woofer has woofs display  -->
		<?php if(isset($myPosts)) : ?>
			<h2>Your Woofs</h2>
			<?=$myPosts?>
		<?php endif; ?>
		
	<!-- Otherwise display 3 recent woofs from other woofers  -->
		<?php if(isset($allPosts)) : ?>
			<h2>Recent Woofs</h2>
			<?=$allPosts?>
		<?php endif; ?>
	</div>
</div>
			
