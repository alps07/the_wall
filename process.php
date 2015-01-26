<?php
	session_start();
	require('new-connection.php');
	if(isset($_POST['action'] )&& $_POST['action'] == 'register')
	{
		//call to function
		register_user($_POST);
	}
	elseif(isset($_POST['action'] )&& $_POST['action'] == 'login')
	{
		login_user($_POST);
	}
	elseif(isset($_POST['action'] )&& $_POST['action'] == 'post_message')
	{
		post_message($_POST);
	}
	elseif(strpos($_POST['action'], 'post_comment') !== FALSE)
	{
		$keys = explode(" ", $_POST['action']);
		$message_id = $keys[1];
		post_comment($_POST, $message_id);
	}
	else//malicious navigation to process.php OR someone is trying to log off
	{
		var_dump('i m in else');
		// session_destroy();
		// header('location:index.php');
		// die();
	}


	function register_user($post)
	{
		/////-----------begin validation checks---------------
		$_SESSION['errors'] = array();

		if(empty($post['first_name']))
		{
			$_SESSION['errors'][]="first name can't be blank!";
		}

		if(empty($post['last_name']))
		{
			$_SESSION['errors'][]="last name can't be blank!";
		}

		if(empty($post['password']))
		{
			$_SESSION['errors'][]="password feild is required!";
		}

		if($post['password'] !== $post['confrim_password'])
		{
			$_SESSION['errors'][] = "passwords must match!";
		}

		if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
		{
			$_SESSION['errors'][] = "please use a valid email address!";
		}

		////----------------end of validation checks----------------

		if(count($_SESSION['errors']) > 0)
		{
			header('location:index.php');
			die();
		}
		else ///now you need to insert the data into the database!
		{
			$query = "INSERT INTO users (first_name, last_name, password, email, created_at, updated_at)
					 VALUES ('{$post['first_name']}', '{$post['last_name']}', '{$post['password']}','{$post['email']}',
					 			NOW(), NOW())";
			var_dump(run_mysql_query($query));

			$_SESSION['success_message'] = 'user successfully created!';

			//get register user_id
			$query = "SELECT id FROM users WHERE first_name = '{$post['first_name']}'";
			var_dump($query);
			$get_user_id = fetch_record($query);
			//var_dump($get_user_id);
			if(!empty($get_user_id)){
				$_SESSION['user_id'] = $get_user_id['id'];
			}
			//set first name to greet 
			$_SESSION['first_name'] = $post['first_name'];

			
			//get all the message with users
			fetch_all_users_with_messages();	


			header('location:page.php');
			die();
		}
		
	}

	function login_user($post)
	{
		$query = "SELECT * FROM users WHERE users.password = '{$post['password']}' 
					AND users.email = '{$post['email']}'";
		$user = fetch_all($query);//go and attempt to grab user with above credentials!
		if(count($user) > 0 )
		{
			$_SESSION['user_id'] = $user[0]['id'];
			$_SESSION['first_name'] = $user[0]['first_name'];
			$_SESSION['logged_in'] = TRUE;

			//get all the message with users
			fetch_all_users_with_messages();
			header('location:page.php');
		}
		else
		{
			$_SESSION['errors'][] = "Can't find  a user with those credentials!";
			header('location:index.php');
			die();
		}
	}


	function post_message($post){

		if(isset($post['message_to_post']) && isset($_SESSION['user_id']))
		{
			//var_dump('i am in post message!!!!!' );
			// var_dump($_SESSION['user_id'][]);
			// var_dump($post['message_to_post']);
			//die();
			$query = "INSERT INTO messages (user_id, message, created_at, updated_at) 
						VALUES ('{$_SESSION['user_id']}', '{$post['message_to_post']}', NOW(), NOW())";
			run_mysql_query($query);

			//get all the message with their repective user
			fetch_all_users_with_messages();
			
			// header('location:page.php');
			// die();
		}

	}

	function post_comment($post, $message_id)
	{
		var_dump('i am in comment post');
		var_dump($post);
		var_dump( $message_id);
				
		// if(isset($post['txtrea_comment']) && isset($_SESSION['user_id']))
		// {
		// 	// $query = "INSERT INTO comments (user_id, message, created_at, updated_at) 
		// 	// 			VALUES ('{$_SESSION['user_id']}', '{$post['message_to_post']}', NOW(), NOW())";
		// 	// run_mysql_query($query);
		// 	//var_dump($post);
		// }
	}



	function fetch_all_users_with_messages(){
		$query = "SELECT CONCAT_WS(' ' , users.first_name, users.last_name,DATE_FORMAT(messages.created_at, '%M %e %Y')) as full_name, messages.message,
					messages.id as message_id FROM users JOIN messages ON messages.user_id = users.id ORDER BY messages.created_at DESC";
			$result = fetch_all($query);
			$_SESSION['user_and_msg'] = $result;
			//var_dump($result);
	}
?>