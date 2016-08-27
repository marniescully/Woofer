<?php
class users_controller extends base_controller {

	public function __construct() {
		
		parent::__construct();
		
	}	# End of Method

	public function index() {

		# Make sure Woofer is logged in 
	        if(!$this->user) {
	            Router::redirect("/"); 

        # If logged in Redirect to Profile page    
	        } else {
	        	Router::redirect("/users/profile");
	        }	   
	
	}	# End of Method

	public function signup() {

		# Set Up view
			$this->template->content 				= View::instance('v_users_signup');
			$this->template->title 					= "Sign Up";
			$this->template->content->first_name 	= '';
			$this->template->content->last_name 	= '';
			$this->template->content->email 		= '';
			$this->template->content->password 		= '';

			$client_files_head = Array("/js/jquery-1.10.2.min.js","/js/jstz-1.0.4.min.js","http://cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js");
	    	$this->template->client_files_head = Utils::load_client_files($client_files_head);
			
		# No errors yet
			$error = false;

		# Initiate error
			$this->template->content->error = '<br>';
		
		# If not submitted yet 
			if(!$_POST) {
				echo $this->template;
				return;
		
		# If submitted
			} else {
				
				# If the field isn't blank return $_POST value
					foreach($_POST as $field_name => $value) {
						if(!empty($field_name))   {
							$this->template->content-> $field_name = $value;
						}
					}	
			}
		
		# Begin Error Checking of Sign Up form

		# If a field was blank, return error
			foreach($_POST as $field_name => $value) {
				if(empty($value)) {
					$this->template->content->error .= str_replace('_',' ', (ucfirst($field_name))).' was blank. Bad Dog!<br>';
					$error = true;
				}
			}	
		
		# Set the maximum limit of the number of characters in fields
        	$limit 	= 25;

		# If a field was more than 25 characters or less than 1, add a message to the error View variable
			foreach($_POST as $field_name => $value) {
				if(strlen($value) > $limit) {
					$this->template->content->error .= str_replace('_',' ', (ucfirst($field_name))).' was more than 25 characters. Try again doggie!<br>';
					$error = true;
				} 
			}
						
		# Verify email is in correct format, but not blank, send error if bad format
			if (!filter_var(($_POST["email"]), FILTER_VALIDATE_EMAIL) && (!empty($_POST["email"]))) {
			  		$this->template->content->error_email = 'Email address not in correct format. Bad Dog!<br>';
					$error = true;
			}

		# Sanitize first because there are bad dogs out there
			$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		# Compare form email with database emails 
	        $q = "SELECT users.email
            	FROM users
	            WHERE users.email = '".$_POST['email']."'";
            
        # Return any emails that match form email
        	$matched_email = DB::instance(DB_NAME)->select_row($q);

       	# Email exists in the database return error message
	        if($matched_email) {
	        	$this->template->content->error_email = 'Email address already exists. Try another email address doggie.<br>';
				$error = true;
	        } 

        # End of Error Checking

		# If no errors after submission
			if(!$error) {
				# More data we want stored with the user
					$_POST['created'] 	= Time::now();
					$_POST['modified'] 	= Time::now();
					
				# Note from Marnie in 2016- sha1 is not a very secure hashing algorithm 
				# but was what my assignment required at the time 
				# Salt should be generated using a
				# Cryptographically Secure Pseudo-Random Number Generator (CSPRNG)
				
				# Encrypt the password
					$_POST['password'] 	= sha1(PASSWORD_SALT.$_POST['password']);
				 
				# Encrypt the token
					$_POST['token'] 	= sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

				# Insert this user into the database
					$user_id = DB::instance(DB_NAME)->insert('users',$_POST);

				# Sign up just created the token, now find it to set the cookie to login
				    $q = "SELECT token 
				        FROM users 
				        WHERE email 	= '".$_POST['email']."' 
				        AND password 	= '".$_POST['password']."'";

	   				$token = DB::instance(DB_NAME)->select_field($q);

        		# Set a cookie on the user's browser of the token value in DB
        			setcookie("token", $token, strtotime('+1 year'), '/');

        		# Send them to the profile page as if they manually logged in
        			Router::redirect("/users/profile");

			} else {

				# Render template
		    		echo $this->template;
			}

	}	# End of Method


	public function p_login() {

		# This processes the login form on the index page

	    # Begin Error Checking of Login Form of blank fields
	 	
	 	# Verify email is in correct format, but not blank, send error if bad format
		 	if(!filter_var(($_POST["email"]), FILTER_VALIDATE_EMAIL) && (!empty($_POST["email"]))) {
				  		Router::redirect("/index/index/format");
			}

	    # Checking to see if email field and password field is blan, display error
			if(empty($_POST['email']) && empty($_POST['password'])) {
				Router::redirect("/index/index/both");

	    # If just email was blank, display error
			} elseif(empty($_POST['email'])) {
		        Router::redirect("/index/index/email");

        # If just password was blank, display error
			} elseif(empty($_POST['password'])) {
				Router::redirect("/index/index/pword");
			}

		# End of Error Checking

	    # Hash submitted password so we can compare it against one in the db
	    	$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

	    # Sanitize first because there are bad dogs out there
			$_POST = DB::instance(DB_NAME)->sanitize($_POST);

	    # Search the db for this email and password
	    # Retrieve the token if it's available
		    $q = "SELECT token 
		        FROM users 
		        WHERE email 	= '".$_POST['email']."' 
		        AND password 	= '".$_POST['password']."'";

	    	$token = DB::instance(DB_NAME)->select_field($q);

	    # If we didn't find a matching token in the database, it means login failed
	    	if(!$token) {

	        # Send them back to the index page with bad login message
	        	Router::redirect("/index/index/error");

	    # But if we did, login succeeded! 
		    } else {
		        # Set a cookie on the user's browser of the token value in DB
		        	setcookie("token", $token, strtotime('+1 year'), '/');

		        # Send them to the profile page
		        	Router::redirect("/users/profile");

		    }

	}	# End of Method

	public function logout() {
		
		# Generate and save a new token for next login
    		$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

    	# Create a New Token
    		$data = Array("token" => $new_token);

	    # Do the update
	    	DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

	    # Delete their token cookie by setting it to a date in the past - effectively logging them out
	    	setcookie("token", "", strtotime('-1 year'), '/');

	    # Send them back to the main index.
	    	Router::redirect("/");

	}	# End of Method

	public function profile() {

		# Make sure Woofer is logged in or redirect to index page
	        if(!$this->user) {
	        	Router::redirect("/");
	        }

	    # Set Up View
		    $this->template->content 				= View::instance('v_users_profile');
		    $this->template->title   				= "Profile of ".$this->user->first_name;
		    $this->template->content->first_name 	= $this->user->first_name;
		    $this->template->content->last_name 	= $this->user->last_name;
		    $this->template->content->age 			= $this->user->age;
		    $this->template->content->email 		= $this->user->email;
			$this->template->content->location 		= $this->user->location;
			$this->template->content->bio 			= $this->user->bio;
			$this->template->content->avatar 		= $this->user->avatar;
		
		# Create variable to reference logged in Woofer in query
			$this_user_id = $this->user->user_id;

		# This selects all posts from logged in Woofer 
	        $q = "SELECT posts.*,
	        	 users.first_name,
	        	 users.timezone,
	        	 users.avatar
	            FROM posts
	            JOIN users 
	            WHERE posts.user_id = users.user_id
	            AND users.user_id= '$this_user_id' 
	            ORDER BY posts.created DESC
	            LIMIT 3"; 

        # Find logged in Woofer posts in DB
        	$posts = DB::instance(DB_NAME)->select_rows($q);

	        if($posts) {
	        	# Display logged in Woofer's post on their profile page
	        		$this->template->content->myPosts 			= View::instance('v_users_profile_posts');
		        	$this->template->content->myPosts->posts 	= $posts;
	        
        # No posts yet from Woofer so display all 3 recent posts from all Woofers
	        } else {
		        
		        # This selects all Woofs from all Woofers
			        $q = "SELECT posts.*,
			        	 users.first_name,
			        	 users.timezone,
			        	 users.avatar
			            FROM posts
			            JOIN users 
			            WHERE posts.user_id = users.user_id 
			            ORDER BY posts.created DESC
			            LIMIT 3";

		        # Find 3 recent Woofs from all Woofers
		        	$posts = DB::instance(DB_NAME)->select_rows($q);

		    	# Display 3 recent posts from all Woofers on the logged in Woofer's profile page
		    		$this->template->content->allPosts 			= View::instance('v_users_profile_posts');
		        	$this->template->content->allPosts->posts 	= $posts;
	        }

        # Render template
	    	echo $this->template;

	}	# End of Method

	public function edit_profile($user_name = NULL) {

		# Make sure Woofer is logged in or redirect to index page
	        if(!$this->user) {
	        	Router::redirect("/");
	        }

        
		# Set Up View
			$this->template->content 				= View::instance('v_users_edit_profile');
			$this->template->title   				= "Profile of ".$this->user->first_name;
		    $this->template->content->first_name 	= $this->user->first_name;
		    $this->template->content->last_name 	= $this->user->last_name;
		    $this->template->content->age 			= $this->user->age;
		    $this->template->content->email 		= $this->user->email;
			$this->template->content->location 		= $this->user->location;
			$this->template->content->bio 			= $this->user->bio;


		# No errors yet
			$error = false;

		# Initiate error
			$this->template->content->error 		= '<br>';
		
		# If not submitted yet 
			if(!$_POST) {
				echo $this->template;
				return;
		
		# If submitted
			} else {
				
				# If the field isn't blank return $_POST value
					foreach($_POST as $field_name => $value) {
						if(!empty($field_name)) {
							$this->template->content-> $field_name = $value;
						}
					}	
			}

		# If Cancel button is clicked, Send them to back to Woofer profile page 
			if (($_POST['submit']) =='Cancel') {
				Router::redirect("/users/profile");
			}

		# Begin Error Checking of Edit Profile form

		# Verify email is in correct format but not blank, send error if bad format
			if (!filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL) && (!empty($_POST['email']))) {
				$this->template->content->error_email = 'Email address not in correct format. Bad Dog!<br>';
				$error = true;
			}

		# Checking to see if age field has more than 2 characters
        	$limit = 2;

        # If age entered is greater than 2 digits, return error
	        if(strlen($_POST['age']) > $limit) {
	            $this->template->content->error .= 'Age is 2 digits at most. Try again doggie!<br>';
				$error = true;
	        } 


        # Set the limit of the number of characters in fields
        	$limit = 25;

        # If a field (but not bio) was more than 25 characters, return error
			foreach($_POST as $field_name => $value) {
				if(strlen($value) > $limit && ($field_name != 'bio')) {
					$this->template->content->error .= str_replace('_',' ', (ucfirst($field_name))).' was more than 25 characters. Try again doggie!<br>';
					$error = true;
				}
			}	

		# Set the limit of the number of characters in bio field
        	$limit = 150;

        # If Bio content is more than 150 characters, return error
	        if(strlen($_POST['bio']) > $limit) {
	        	$this->template->content->error .= 'We don\'t need your whole life story. Just 150 characters please. Try again doggie!<br>';
				$error = true;
	        } 

        # Set the maximum age of a dog.
        	$limit= 32;

        # If age is greater than 32, the oldest recorded age of a dog according to Guinness World Records, return error
	        if(($_POST['age']) > 32) {
				$this->template->content->error .= 'Have <em>Guinness World Records</em> update their records in order to register. You are the oldest dog ever!<br>';
				$error = true;
	        } 

		# If a field was blank, return error
			foreach($_POST as $field_name => $value) {
				if($value == '') {
					$this->template->content->error .= str_replace('_',' ', (ucfirst($field_name))).' was blank. Bad Dog!<br>';
					$error = true;
				} 
			}

		# Sanitize first because there are bad dogs out there
			$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		# This compares form email with database emails 
	        $q = "SELECT users.email
	            FROM users
	            WHERE users.email = '".$_POST['email']."'";
	            
        # Find any email address in DB that matches what is in form
        	$matched_email = DB::instance(DB_NAME)->select_row($q);

        # Email exists in the database, but isn't this user's email
	        if($matched_email && (($_POST["email"]) != $this->user->email)) {
	        	$this->template->content->error_email = 'Email address already exists. Try another doggie.<br>';
				$error = true;
	        } 

        # End of Error Checking

        # Processing Upload of avatar image

        # If Image is too large to upload
			if($_FILES['avatar']['error'] == 1) {
				$this->template->content->error = 'Image file way too big. Try again doggie!<br>';
				$error = true;
			}
        
        # If nothing was uploaded
        	if($_FILES['avatar']['error'] == 4) {
        	
        	# Determine if avatar is the default or if they have uploaded one already
        	# If they only have the default image then keep that as their avatar
		    	if ($this->user->avatar == '/uploads/avatars/DancingSnoopy_sm.jpg') {
		    		$avatar = 'DancingSnoopy_sm.jpg';
    		
    		 # If they have uploaded an image in the past, keep that image, they don't have to upload it again
		    	} else {
			 		$avatar = trim(str_replace('/uploads/avatars/','', $this->user->avatar ));
		    	}

        # They have uploaded an image	 
        	} else {

        	# If no other errors occured, then upload the image
	        	if($_FILES['avatar']['error'] == 0) {
			    	# Insert the image into the avatars folder and rename it with the user id before the file extension
			 			$avatar = Upload::upload($_FILES, "/uploads/avatars/", array("jpg", "jpeg", "gif", "png", "JPG","JPEG","GIF","PNG"), $this->user->user_id);

			 		# Resize the image for faster downloads and consistent display
				 		$imgObj = new Image(APP_PATH . '/uploads/avatars/' . $avatar);
		                $imgObj->resize(110, 110, "crop");
		                $imgObj->save_image(APP_PATH."uploads/avatars/". $avatar); 

			 		# Check if file extension of image is one of the allowed types, if not return error.
			 		if($avatar == 'Invalid file type.') {
			        	$this->template->content->error = 'Image file was an invalid error type. Try again doggie!<br>';
						$error = true; 
			    	}
		    	}
	    	}	
        
        # End of Uploading image - now insert avatar name with the main UPDATE query

		# If no errors after submission, Update their profile
			if(!$error) {
				$q = "UPDATE users SET 
				    first_name = '".$_POST['first_name']."', 
				    last_name = '".$_POST['last_name']."', 
			    	age = '".$_POST['age']."', 
				    email = '".$_POST['email']."',
				    location = '".$_POST['location']."',
				    bio = '".$_POST['bio']."',
				    avatar = '$avatar'
				    WHERE user_id = " .$this->user->user_id; 

			# Run the command
				DB::instance(DB_NAME)->query($q);

			# Send them to Woofer profile page to view their changes
		    	Router::redirect("/users/profile");

		}

			# Render template
	    		echo $this->template;
		
	}	# End of Method

}	# End of the class
