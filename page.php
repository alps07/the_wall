<!DOCTYPE HTML>
<html>
<head>
	<title>The WALL</title>
	<link rel="stylesheet" href="page.css">
	<?php session_start();

	?>
</head>
<body>
	<div class='header'> 
		<h1>CodingDojo Wall</h1>
	<?php   if(isset($_SESSION['first_name']))
			{
				echo "<h3>welcome {$_SESSION['first_name']} </h3>";
				//unset($_SESSION['first_name']);
			}?> 
		<a href="index.php">Log Off</a>
	</div>
	<h3 id="post_heading">Post a message</h3>
	<form id="post_form" action="process.php" method="post">
		<textarea name="message_to_post"></textarea>
		<input class="post_button" type="submit" name="submit" value="Post a message">
		<input type="hidden" name="action" value="post_message"> 
	</form>
	<?php if(isset($_SESSION['user_and_msg']))
			{
				foreach ($_SESSION['user_and_msg'] as $value) {
					echo "<h4 class='heading_post'>{$value['full_name']}</h4>";
					echo "<div class='messages'><p>{$value['message']}</p></div>";
					$val = 'post_comment '.$value['message_id'];
					echo "<form class='comment_form' action='process.php' method='post'>							
							<textarea class='txtrea_comment' name= 'comment_to_post'></textarea>
							<input class='comment_button' type='submit' name='submit' value='Post a comment'>
							<input type='hidden' name='action' value='$val'> 
							</form> ";
				}
				unset($_SESSION['user_and_msg']);

			}
	?>
	<div id="main_content">
	<!--check for session for messages  and create p tag for those with user_id -->
		<h4 class="heading_post">Micheal Choi-January 23rd 2013</h4>
		<div class="messages">
			<p>
				At vero eos et accusamus et iusto odio dignissimos ducimus
				qui blanditiis praesentium voluptatum deleniti atque corrupti
				quos dolores et quas molestias excepturi sint occaecati cupiditate n
				on provident, similique sunt in culpa qui officia deserunt mollitia
				animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis 
				est et expedita distinctio. Nam libero tempore, cum soluta nobis est
				eligendi optio cumque nihil impedit quo minus id quod maxime placeat 
				facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.
			</p>
		</div>
		<h4 class="heading_comment">Alice Turro-Feburary 12th 2013</h4>
		<div class="comments">
			<p>
				At vero eos et accusamus et iusto odio dignissimos ducimus
				qui blanditiis praesentium voluptatum deleniti atque corrupti
				quos dolores et quas molestias excepturi sint occaecati cupiditate n
				on provident, similique sunt in culpa qui officia deserunt mollitia
				animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis 
			</p>
		</div>
		<form class="comment_form" action="process.php" method="post">
			<textarea class="txtrea_comment" name="comment_to_post"></textarea>
			<input class="comment_button" type="submit" name="submit" value="Post a comment">
			<input type="hidden" name="action" value="post_comment"> 
		</form> 
	</div>
</body>
</html>