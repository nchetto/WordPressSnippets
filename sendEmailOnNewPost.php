<?php

// Send email to a list of recipients when a new post is published
function send_email_on_new_post($post_id, $post, $old_status) {

	// Recipient list
	$to_list = array(
		'example@email.com',
		'example@email.com'
	);

	// Ensure the function runs only once per post when post is published
	// Modify the post status to send also when post is updated or trashed
	if ($old_status != 'publish') {

		// Prepare email data
		$post_url = get_permalink($post_id);
		$post_title = get_the_title($post_id);
		$post_title = html_entity_decode($post_title, ENT_QUOTES, 'UTF-8');
		$subject = "New post on my site - {$post_title}";
		$message = "Hi,\n\nA new post has just been published: {$post_title}\nYou can find it at: {$post_url}\n\nThanks!";
		$headers = 'From: Notifier <noreply@email.com>';

		// Send email to each recipient
		foreach ($to_list as $to) {
			// Use wp_mail() to send email
			wp_mail($to, $subject, $message, $headers);
		}
	}
}

// Hook into the publish_post action
add_action('publish_post', 'send_email_on_new_post', 10, 3);

?>