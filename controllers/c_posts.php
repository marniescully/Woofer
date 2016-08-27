<?php 
class posts_controller extends base_controller {

    public function __construct() {
        
        parent::__construct();
        
         # Make sure Woofer is logged in or redirect to index page
            if(!$this->user) {
                Router::redirect("/");
            }

    }   # End of Method

    public function index() {
        
        # All Woofs from All Woofers 

        # Set Up View
            $this->template->content = View::instance('v_posts_index');
            $this->template->title   = "All Woofs from All Woofers";

        # This selects all posts from all users
            $q = "SELECT posts.*,
                 users.first_name,
                 users.timezone, 
                 users.avatar
                FROM posts
                JOIN users 
                WHERE posts.user_id = users.user_id 
                ORDER BY posts.created DESC";

        # Find posts in DB
            $posts = DB::instance(DB_NAME)->select_rows($q);

        # Send DB rows to Views
            $this->template->content->posts = $posts;

        # Render template
            echo $this->template;
        
    }   # End of Method

    public function mine() {
        
        # All Woofs from logged in Woofer

        # Set Up View
            $this->template->content = View::instance('v_posts_mine');
            $this->template->title   = "My Woofs";

        # Create variable to reference logged in Woofer in query
            $this_user_id = $this->user->user_id;
        
        # This selects all Woofs from just the logged in Woofer
            $q = "SELECT
                     posts.* , 
                     users.first_name,
                     users.timezone,
                     users.avatar
                FROM posts
                JOIN users 
                WHERE posts.user_id = users.user_id
                AND users.user_id = '$this_user_id' 
                ORDER BY posts.created DESC"; 

        # Find Woofs in DB
            $posts = DB::instance(DB_NAME)->select_rows($q);

        # Send DB rows to Views
            if($posts) {
                $this->template->content->posts = $posts;
            } else {
                $this->template->content->message = true;
            }

        # Render template
            echo $this->template;
        
    }   # End of Method

    public function followed() {
        
        # All Woofs from Woofers followed by logged in Woofer

        # Set Up View
            $this->template->content = View::instance('v_posts_followed');
            $this->template->title   = "Woofs from Woofers I follow";
        
        # Create variable to reference logged in Woofer in query
            $this_user_id = $this->user->user_id;

        #This selects all Woofs from all Woofers
            $q = "SELECT 
                    posts.content,
                    posts.created,
                    posts.user_id AS post_user_id,
                    users_users.user_id AS follower_id,
                    users.first_name,
                    users.last_name,
                    users.timezone,
                    users.avatar
                FROM posts
                INNER JOIN users_users 
                    ON posts.user_id = users_users.user_id_followed
                INNER JOIN users 
                    ON posts.user_id = users.user_id
                WHERE users_users.user_id = '$this_user_id' 
                ORDER BY posts.created DESC";

        # Find Woofs in DB
            $posts = DB::instance(DB_NAME)->select_rows($q);

        # If they have Woofed, show their Woofs
            if($posts) {
                $this->template->content->posts = $posts;

        # If no Woofs yet display message prompting them to Woof
            } else {
                $this->template->content->message = true;
            }

        # Render template
            echo $this->template;
        
    }   # End of Method

    public function add($error=NULL) {
        
        # Set Up View
            $this->template->content        = View::instance('v_posts_add');
            $this->template->title          = "New Woof";
            $this->template->content->error = $error;
        
        # Render template
            echo $this->template;

    }   # End of Method

    public function p_add() {

        # Error Checking of Add Woof Form           

        # Set the limit and minimum of the number of characters to Woof
            $limit      = 100;
            $minimum    = 2;

        # If content field has more than 200 characters,
        # Return error
            if(strlen($_POST['content']) > $limit) {
                Router::redirect("/posts/add/max_limit/");             
           
            # If content field is has only 1 character, return error
            } else {
                if(strlen($_POST['content']) < $minimum) {
                    Router::redirect("/posts/add/minimum/");  
                # If content field is blank, return error
                } 
            }
    
        # No errors then proceed

        # Associate this Woof with this Woofer
            $_POST['user_id']  = $this->user->user_id;

        # Unix timestamp of when this Woof was created / modified
            $_POST['created']  = Time::now();
            $_POST['modified'] = Time::now();

        # Insert
            DB::instance(DB_NAME)->insert('posts', $_POST);

        # Send them to their Woofs
            Router::redirect("/posts/mine");

    }   # End of Method

    public function users() {
        
        # Lists All Woofers

        # Set Up View
            $this->template->content = View::instance("v_posts_users");
            $this->template->title   = "Woofers";
            
        # Build the query to get all the Woofers
            $q = "SELECT *
                FROM users
                WHERE user_id <> " .$this->user->user_id;

        # Execute the query to get all the Woofers. 
        # Store the result array in the variable $users
            $users = DB::instance(DB_NAME)->select_rows($q);

        # Build the query to figure out what connections does this user already have? 
        # I.e. who are they following
            $q = "SELECT * 
                FROM users_users
                WHERE user_id = ".$this->user->user_id;

        # Execute this query with the select_array method
        # Store our results (an array) in the variable $connections
            $connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');

        # Pass data (Woofers and connections) to the view
            $this->template->content->users       = $users;
            $this->template->content->connections = $connections;

        # Render the view
            echo $this->template;
    
    }   # End of Method


    public function follow($user_id_followed) {

        # Follow a Woofer

        # Prepare the data array to be inserted
            $data = Array (
                "created" => Time::now(),
                "user_id" => $this->user->user_id,
                "user_id_followed" => $user_id_followed
                );

        # Insert
            DB::instance(DB_NAME)->insert('users_users', $data);

        # Send them back to view of Woofers
            Router::redirect("/posts/users");

    }   # End of Method

    public function unfollow($user_id_followed) {
        
        # Unfollow a Woofer
        
        # Delete this connection
            $where_condition = 'WHERE user_id = '.$this->user->user_id.'
                                AND user_id_followed = '.$user_id_followed;
            DB::instance(DB_NAME)->delete('users_users', $where_condition);

        # Send them back to view of Woofers
            Router::redirect("/posts/users");

    }   # End of Method
        
}   # End of Class