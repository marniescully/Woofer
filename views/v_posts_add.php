<nav>
	<a href='/posts/followed'>Woofstream</a> |
	<a href='/posts/mine'>My Woofs</a> |
	<a href='/posts/'>All Woofs</a> |
	<a href='/posts/add' class='selected'>Woof!</a> |
	<a href='/posts/users'>Woofers</a> 
</nav>

<div class='single_col'>

	<form method='POST' action='/posts/p_add'>
	    <h2>New Woof:</h2><br>
	    <textarea name='content' id='content' ></textarea><br><br>
	    
	    <input type='submit' id='woof' value='Add Woof'>

	    <!-- Show error if post is > 100 characters  -->
			<?php if(isset($error) && $error == 'max_limit'): ?>
				<p class='error'>We don't need your whole life story.
					<br>Just 100 characters please. Try again doggie!
				</p>

		<!-- Show error is less than 2 characters  -->
			<?php elseif(isset($error) && $error == 'minimum'): ?>
				<p class='error'>Why woof if that was all you had to say?
					<br>Try again doggie!
				</p>
			<?php endif; ?>

	</form> 
</div>

