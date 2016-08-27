<nav>
	<a href='/posts/followed'>Woofstream</a> |
	<a href='/posts/mine' class='selected'>My Woofs</a> |
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
		
		<article>
			<h1>You have not woofed any woofs yet. <a href='/posts/add'>Get to Woofing! </a></h1>
		</article>
	
	<?php endif; ?>
</div>