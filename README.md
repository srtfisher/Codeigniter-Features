# Codeigniter Feature Flags

Enabling features for select users is a fun and also productive way to develop new features into a site. You can enable features, or certain sections of code based upon a number of factors. Take a look at config/features.php for more on that. 

## Setting Up

You need to set the current user's ID before you can use the User ID part of this. You can do that by calling:
`$this->feature->set_user($the_user_id);`

## Using the Flags

Setting up the flags are simple. We included a helper function to test for the feature with the current user to make your life even simplier! Just use this code

	<?php
	if (can_do_feature('the_feature_name'))
	{
		// The code to execute if they can perform a feature
	
	}
	?>

## Questions?
Shoot me an email at http://talkingwithsean.com/contact/