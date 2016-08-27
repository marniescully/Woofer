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