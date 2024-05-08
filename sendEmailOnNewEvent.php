<?php

// Send email to a list of recipients when a new event is published
// Events are posts created by https://theeventscalendar.com/ as tribe_events
function send_email_on_new_event( $new_status, $old_status, $post ) {

	// Recipient list
	$to_list = array(
		'example@email.com',
		'example@email.com'
	);
	
	// Ensure the function runs only once per post when post is published
	// Modify the post status to send also when post is updated or trashed
	if ( $old_status == $new_status || $new_status != 'publish' )
		return;
	
	// Detect if post is a event
	$post_type = get_post_type($post->ID);
	if ( $post_type != 'tribe_events')
		return;

	// Prepare email data
	$event_url = tribe_get_event_link($post);
	$event_title = $post->post_title;
	$event_title = html_entity_decode($event_title, ENT_QUOTES, 'UTF-8');
	
	if($event_url != ''){
		$subject = "{$event_title} - New event on my site";
		$message = "Hi,\n\nA new post has just been published: {$event_title}\nYou can find it at: {$event_url}\n\nThanks!";
		$headers = 'From: Notifier <noreply@email.com>'; 

		// Send the email
		foreach ($to_list as $to) {
			wp_mail($to, $subject, $message, $headers);
		}
	}
}

// Hook into the publish_post action
add_action('publish_post', 'send_email_on_new_event', 10, 3);

?>