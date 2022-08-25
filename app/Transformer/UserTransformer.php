<?php
namespace App\Transformer;

use App\Models\User;
use League\Fractal\TransformerAbstract;

Class UserTransformer extends TransformerAbstract {
       
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'user_id'                   => $user->id,
            'username'                  => $user->username,
            'email'                     => $user->email,
            'first_name'                => $user->first_name,
            'last_name'                 => $user->last_name,
            'full_name'                 => $user->full_name,
            'gender'                    => $user->gender,
            'mobile'                    => $user->mobile,
            'user_type'                 => $user->user_type,
            'fb_id'                     => $user->fb_id,
            'country_code'              => $user->country_code,
            'country_name'              => $user->country_name,
            'dob'                       => $user->dob,
            'weight'                    => $user->weight,
            'mobility'                  => $user->mobility,
            'push_notification'         => $user->push_notification,
            'profile_pic'               => $user->profile_pic?(url('/').'/storage/pictures/'.$user->profile_pic):null,
            'last_login_at'             => $user->updated_at ? $user->updated_at->toDateTimeString() : null,
            'registered_at'             => $user->registered_at->toDateTimeString(),
            'updated_at'                => $user->updated_at->toDateTimeString()
        ];
    }
}

