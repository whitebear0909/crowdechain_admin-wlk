<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    'user_contact_message' => 'Contact WalkAbout',
    'name_requried' => 'The name field is required',
    'email_required'        => 'The email field is required.',
    'email_invalid'         => 'Email address is not valid.',
    'email_invalid_length'  => 'Email address can be of max {max} characters.',
    'message_requried'     => 'The message field is required.',
    'token_required' => 'The token field is required.',
    'token_not_exist' => 'The token has been expired or invalid.',
    'user_created_successfully' => 'User is created successfully.',
    'user_updated_successfully' => 'User is updated successfully',
    'could_not_update_user' => 'Error in user update',
    'email_invalid' => 'Invalid email.',
    'email_already_taken' => 'Email already taken.',
    'name_required' =>  'The name field is required',
    'username_too_short'    =>  'The username is too short, must at least 6 characters',
    'username_too_large'    =>  'The username is too large, must not be more than 32 characters',
    'password_requried' =>  'The password field is required',
    'credential_invalid' =>  'Username or Password is incorrect.',
    'password_too_short'    =>  'The password is too short, must be at least 6 characters',
    'password_too_large'    =>  'The password is too large, must not be more than 32 characters',
    'username_invalid'  =>  'The username is invalid.',
    'username_already_taken' => 'Username already taken',
    'confirm_password_required' =>  'The confirm_password field is required',
    'confirm_password_invalid'  =>  'The password and confirm password must match',
    'firstname_required'    =>  'The first_name field is required',
    'lastname_required' =>  'The last_name field is required',
    'could_not_create_user' => 'The user can not be created due to server error',
    'user_type_key_required' => 'The user_type key is required',
    'user_profile_picture_upload_successfully' => 'Your profile picture upload successfully',
    'user_profile_picture_missing' => 'Profile picture is missing',
    'profile_picture_required' => 'The picture key or profile picture is required',
    'current_password_required' => 'The current_password key is required',
    'new_password_required' => 'The new_password key is required',
    'new_password_short' => 'The new_password password is too short',
    'new_password_longer' => 'The new_password password is too longer',
    'new_confirm_password_different' => 'New password and Confirm password not exactly same',
    'current_password_incorrect' => 'The current/old password is incorrect',
    'confirm_password_required' => 'The confirm_password key is required',
    'password_updated_successfully' => 'The password has been updated successfully',
    'user_type_required' => 'The user_type key is required',
    'user_deleted_successfully' => 'The user has been deleted successfully',
    'user_id_requried' => 'The id is required',
    'user_id_invalid' => 'The user id is invalid',
    'symptom_id_requried' => 'The symptom_id key is required',
    'symptom_id_invalid' => 'The symptom_id is invalid',
    'symptom_followed_successfully' => 'You have been followed the symptom successfully',
    'invite_user_id_requried' => 'The invite_user_id key is requried',
    'invite_user_id_invalid' => 'The invite_user_id is invalid',
    'user_invited_successfully' => 'The user is invited successfully',
    'user_already_invited_successfully' => 'You have already invited to this user',
    'friend_id_requried' => 'The friend_id key is requried',
    'friend_id_invalid' => 'The friend_id is invalid',
    'invite_response_status_requried' => 'The status key is required',
    'response_submitted_successfully' => 'Your response submitted successfully',
    'invite_response_request_id_requried' => 'The request_id key is requried',
    'invite_response_request_id_invalid' => 'The request_id is invalid',
    'device_token_requried' => 'The device_token key is requried',
    'profile_updated_successfully' => 'Your profile updated successfully',
    'giftcardid_requried' => 'The giftcard_id key is requried',
    'gift_cards_invalid' => 'The gift_cards is invalid',
    'gift_cards_requried' => 'The gift_cards is requried',
    'giftcardid_invalid' => 'The giftcard_id invalid',
    'giftcard_added_successfully' => 'The gift card added successfully',
    'cart_item_id_requried' => 'The cart item_id key is required',
    'cart_item_id_invalid' => 'The cart item_id key is invalid',
    'item_deleted_successfully' => 'The cart item deleted successfully',
    'total_amount_requried' => 'The total_amount key is requried',
    'amount_to_gift_requried' => 'The amount_to_gift key is requried',
    'donation_amount_requried' => 'The donation_amount key is requried',
    'card_quantity_updated_successfully' => 'The card quantity updated successfully',
    'quantity_requried' => 'The quantity key is requried',
    'total_amount_invalid' => 'The total_amount is invalid',
    'amount_to_gift_invalid' => 'The amount_to_gift is invalid',
    'gift_cards_object_invalid' => 'The gift_cards object is invalid',
    'tranzparency_title' => 'Transparency',
    'tranzparency_descritpion' => 'This is the description of our system which describes what our tranparency for the thankooh app',
    'tranzparency_below_example' => 'Below is an example of our system: ',
    'push_notification_required' => 'The push_status key required',
    'push_notification_invalid' => 'The push notification is invalid',
    'recipients_required' => 'The recipients are required',
    'notification_setting_updated_successfully' => 'Your push notification setting updated successfully',
    'your_profile_completed_successfully' => 'Your email verified successfully You can login now',
    'wlecom_email_for_registration' => 'Welcome email to complete registration on Thesis WorkflowCRM',
    'welcomebody' => [
        'hello' => 'Hello ',
        'body1' => 'Your Thesis WorkflowCRM account has been created to login into that, you need to verify your email. Click the button below to verify your email.',
        'body2' => 'Vefiry email',
        'verifyemail' => 'If button doesn\'t work, copy and paste the following link in your browser: ' 
    ],
    'activation_link_expired' => 'Activation link has been expired please try later',
    'contactemailbody' => [
        'subject' => 'New user tried to contact you',
        'hello' => 'Hello ',
        'body1' => 'Congratulations! A new user tried to contact you so kindly find his details below:'
    ],
    'ticket_create_notify_body' => [
        'subject' => 'Ticket :Ticketname - :WorkflowName Inserito',
        'hello' => 'Hello ',
        'body1' => 'Un nuovo ticket attende di essere preso in gestione da te, ',
        'click_to_view' => 'clicca qui per accedere' 
    ],
    'ticket_takenincharge_notify_body' => [
        'subject' => 'Ticket :Ticketname - :WorkflowName preso in carico',
        'hello' => 'Hello ',
        'body1' => 'Il tuo ticket è stato preso in carico da :takenBy, ',
        'click_to_view' => 'clicca qui per accedere' 
    ],
    'ticket_move_fromstep_notify_body' => [
        'subject' => 'Ticket :Ticketname - :WorkflowName deve essere preso in carico per lo :stepName',
        'hello' => 'Hello ',
        'body1' => 'Un nuovo ticket attende di essere preso in gestione, ',
        'click_to_view' => 'clicca qui per accedere' 
    ],
    'ticket_closed_notify_body' => [
        'subject' => 'Ticket :Ticketname - :WorkflowName chiuso',
        'hello' => 'Hello ',
        'body1' => 'Il ticket :ticketName è stato completato, ',
        'click_to_view' => 'clicca qui per accedere' 
    ],
];
