<nav>
    <a href='/posts/followed'>Woofstream</a> |
    <a href='/posts/mine'>My Woofs</a> |
    <a href='/posts/'>All Woofs</a> |
    <a href='/posts/add'>Woof!</a> |
    <a href='/posts/users' class='selected'>Woofers</a>

</nav>

<div class='single_col'>
    <h2>All Woofers</h2>
        <?php foreach($users as $user): ?>
            
            <article>
           
                <!-- Display user's avatar -->
                    <img src='/uploads/avatars/<?=$user['avatar']?>' alt='avatar'>

                <!-- Print this user's name -->
                <!-- If there exists a connection with this user black-->
                    <?php if(isset($connections[$user['user_id']])): ?>
                       
                        <h1><?=$user['first_name']?></h1>

                <!-- Otherwise, show gray  -->
                    <?php else: ?>
                       
                        <h3><?=$user['first_name']?></h3>
                    
                    <?php endif; ?>

                    <p><?=$user['bio']?> </p> <br>
                
               <!-- If there exists a connection with this user, show a unfollow link -->
                    <?php if(isset($connections[$user['user_id']])): ?>
                        
                        <p><a href='/posts/unfollow/<?=$user['user_id']?>'>Unfollow</a></p>
                
                <!-- Otherwise, show the follow link -->
                    <?php else: ?>
                        
                        <p><a href='/posts/follow/<?=$user['user_id']?>'>Follow</a></p>
                    
                    <?php endif; ?>
            
            </article>
    
        <?php endforeach; ?>
</div>
