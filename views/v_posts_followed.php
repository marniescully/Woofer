<nav>
	<a href='/posts/followed' class='selected'>Woofstream</a> |
	<a href='/posts/mine'>My Woofs</a> |
	<a href='/posts/'>All Woofs</a> |
	<a href='/posts/add'>Woof!</a> |
	<a href='/posts/users'>Woofers</a>
</nav>

<div class='single_col'>
	
	<?php if(isset($posts)) : ?>
		
		<?php foreach($posts as $post): ?>

			<!-- Display each post  -->
				<article>
				    <img src='/uploads/avatars/<?=$post['avatar']?>' alt='avatar'>
				    <h1><?=$post['first_name']?> woofed:</h1>
				    <p><?=nl2br($post['content'])?></p>
				    <time datetime="<?=Time::display($post['created'],'Y-m-d H:i')?>">
				    	<?=Time::display(($post['created']), '', ($post['timezone'])) ?>
					</time>
				</article>
			
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if(isset($message)) : ?>
		
		<!-- Display message if no Woofers followed yet  -->
			<article>
				<h1>You have not followed any woofers yet. <a href='/posts/users'>Follow some woofers! </a></h1>
			</article>
		
	<?php endif; ?>

</div>