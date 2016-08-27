<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	<link href='/css/woofer.css' rel='stylesheet' type='text/css'>	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	
	<!-- Controller Specific JS/CSS -->
		<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>	
	<header>
		<h1>
			<!-- If not logged in view home page -->
				<?php if(!$user): ?>
					<a href='/'>
			<!--else view profile page -->
				<?php else: ?>
					<a href='/users/profile'>
				<?php endif; ?>
				<img src='/images/paw-print-logo.png' alt='Paw Print'></a> Woofer</h1> 
				
		<!-- Menu for users who are logged in  -->
	        <?php if($user): ?>
	        	<nav>You're a good dog, <?php echo $user->first_name . '!'; ?>
					| <a href='/users/profile'>Profile</a>
	            	| <a href='/users/logout'>Logout</a>
	        	</nav>
       
        <!-- Just display slogan  -->
	        <?php else: ?>
	        	<p>The World's Best Micro-blog Exclusively for Dogs!</p>
	         <?php endif; ?>
			
    </header>

	<section>
        
		<?php if(isset($content)) echo $content; ?>

	</section>
		
	<footer>
	

	<!-- Show copywrite on every page  -->
		<div>
			&copy; 2016 Marnie Scully
		</div>
	</footer>

	<?php if(isset($client_files_body)) echo $client_files_body; ?>
</body>
</html>