<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CommonHelper;
use JWTAuth;
use Auth;
use App;
use Mail;

class UserController extends BaseController
{
    public function __construct(Response $response) {
        $this->model = new \App\Models\User();
        parent::__construct($response);
    }
    
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required',
            'username'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        \App\Models\User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'username' => $request->get('username')
        ]);
        $user = \App\Models\User::first();
        $token = JWTAuth::fromUser($user);
        
        return response()->json(compact('token'));

    }

    public function login(Request $request)
    {
        $messages = [
            'email.required'            => trans('user.email_required'),
            'email.email'               => trans('user.email_invalid'),
            'email.exists'              => trans('user.email_invalid'),
            'password.required'         => trans('user.password_requried'),
            'password.min'              => trans('user.password_too_short'),
            'password.max'              => trans('user.password_too_large')
            
        ];
        $rules = [
            'email'                =>  'required|email|max:96|exists:users,email',
            'password'             =>  'required|min:6|max:20'
        ];

        $validator          = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors()->first());
        }

        try {
            $credentials = [
                'email' => $request->get('email'),
                'password' => $request->get('password')
            ];
            
            if( !$token = JWTAuth::attempt($credentials) ) {
                return $this->response->errorUnauthorized(trans('user.credential_invalid'));
            }
            $user = \App\Models\User::where('email', $credentials['email'])->first();
            
            return response()->json(compact('token'));
            //return $this->response->withArray(['data' => $user, 'meta'=>['http_code'=>200, 'token' => $token]]);
        } catch (Exception $ex) {
            return $this->response->errorInternalError(trans('user.credential_invalid'));
        }
    }

    public function getLoginProfile(Request $request)
    {
        $authUser = JWTAuth::toUser($request->token);
        $user =     \App\Models\User::where('id', '=', $authUser->id)->first();
        $user->roles = array('admin');
        $user->avatar = $user->avatar ? (env('APP_STORAGE_URL').'storage/app/'.$user->avatar) : '';
        $user->api_url = url('/').'/api/';
        $user->upload_file_url = url('/').'/api/upload/file';
        $user->storage_url = env('APP_STORAGE_URL');
        return $this->response->withArray(['data' => $user, 'meta'=>['http_code'=>200]]);

    }

    public function updateProfile(Request $request)
    {   
        $messages = [
            'name.required'             => trans('user.name_requried'),
            'name.max'                  => trans('user.name_too_large')
        ];
        $rules = [
            'name' => 'required',
            'mobile'=> 'required|numeric',
            'dob' => 'required',
            'gender' => 'required',
            'introduction' => 'required',
        ];
        
        $validator          = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors()->first());
        }
        $authUser   =   JWTAuth::toUser($request->token);
        $user       =   \App\Models\User::where('id', '=', $authUser->id)->first();
        $user->name = $request->get('name');
        $user->mobile = $request->get('mobile');
        //$user->dob = $request->get('dob');
        $user->gender = $request->get('gender');
        $user->introduction = $request->get('introduction');
        try {
            $user->save();
        } catch (Exception $e) {
            return $this->response->errorInternalError('user.could_not_update_user');
        }
        return $this->response->withArray(['data' => $user, 'message' => trans('user.user_updated_successfully'), 'meta'=>['http_code'=>200]]);
    }

    public function getUserProfile(Request $request, $id)
    {
        $authUser = JWTAuth::toUser($request->token);
        $user =     \App\Models\User::where('id', '=', $id)->first();
        return $this->response->withArray(['data' => $user, 'meta'=>['http_code'=>200]]);
    }
    
    public function getUserRoles(Request $request)
    {
        $authUser = JWTAuth::toUser($request->token);
        $roles =     \App\Models\Group::where('user_id', '=', $authUser->workstation_id)->orWhere('user_id', '=', $authUser->id)->get();
        return $this->response->withArray(['data' => $roles, 'meta'=>['http_code'=>200]]);
    }

    public function createUser(Request $request)
    {
        $messages = [
            'username.required'         => trans('user.username_required'),
            'username.Unique'           => trans('user.username_already_taken'),
            'name.required'             => trans('user.name_requried'),
            'name.max'                  => trans('user.name_too_large'),
            'email.required'            => trans('user.email_required'),
            'email.email'               => trans('user.email_invalid'),
            'email.Unique'              => trans('user.email_already_taken'),
            'password.required'         => trans('user.password_requried'),
            'password.min'              => trans('user.password_too_short'),
            'password.max'              => trans('user.password_too_large')
        ];
        $rules = [
            'username' => 'required|string|max:255|Unique:users',
            'email' => 'required|string|email|max:255|Unique:users',
            'name' => 'required',
            'password'=> 'required|min:6|max:20',
            'mobile'=> 'required|numeric',
            'role' => 'required',
        ];

        $validator          = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors()->first());
        }
        $adminUser = JWTAuth::toUser($request->token);
        $isSuperAdmin = ($adminUser->usertype == 1)?true:false;
        $user = new \App\Models\User;
        $user->fill([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => \Illuminate\Support\Facades\Hash::make($request->get('password')),
            'mobile' => $request->get('mobile'),
            'usertype' => $isSuperAdmin?2:3,
            'creator' => $adminUser->id,
            'role' => $request->get('role')
        ]);
        try {
            $user->save();
            $credentials = [
                'email' => $request->get('email'),
                'password' => $request->get('password')
            ];
            if( !$token = JWTAuth::attempt($credentials) ) {
                return $this->response->errorUnauthorized(trans('auth.could_not_create_token'));
            }
            $user->email_verify_token = $token;
            $user->workstation_id = $isSuperAdmin ? $user->id : $adminUser->id;
            $user->workstation_name = $isSuperAdmin ? null : $adminUser->workstation_name;
            if($isSuperAdmin) {
                $link = env('APP_DOMAIN_URL').'/#/signup/complete?token='.$token.'&id='.$user->id;
                $body = trans('user.welcomebody');
                Mail::send('emails.welcome', ['user' => $user, 'link' => $link, 'body' => $body], function ($m) use ($user, $link, $body) {
                    $m->to($user->email, $user->name)->subject(trans('user.wlecom_email_for_registration'));
                });
            } else {
                $link = env('APP_DOMAIN_URL').'/#/verify/email?token='.$token.'&id='.$user->id;
                $body = trans('user.welcomebody');
                Mail::send('emails.verifyemail', ['user' => $user, 'link' => $link, 'body' => $body], function ($m) use ($user, $link, $body) {
                    $m->to($user->email, $user->name)->subject(trans('user.wlecom_email_for_registration'));
                });
            }
            $user->save();
        } catch (Exception $e) {
            return $this->response->errorInternalError(trans('user.could_not_create_user'));
        }
        return $this->response->withArray(['data' => $user, 'message' => trans('user.user_created_successfully'), 'meta'=>['http_code'=>200]]);
    }

    public function profileComplete(Request $request)
    {
        $messages = [
            'token.required'                => trans('user.token_required'),
            'userid.required'               => trans('user.userid_required'),
            'workstation_name.required'     => trans('user.workstation_requried')
        ];
        $rules = [
            'token' => 'required|string',
            'userid' => 'required|string',
            'workstation_name' => 'required|string|Unique:users'
        ];

        $validator          = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors()->first());
        }
        $user = \App\Models\User::where('id', '=', $request->get('userid'))->where('email_verify_token', '=', $request->get('token'))->where('email_verified', '=', 0)->first();
        $user->workstation_name = $request->get('workstation_name');
        $user->email_verify_token = '';
        $user->email_verified = 1;
        try {
            $user->save();
        } catch (Exception $e) {
            return $this->response->errorInternalError('user.could_not_complete_user_profile');
        }
        return $this->response->withArray(['data' => $user, 'message' => trans('user.your_profile_completed_successfully'), 'meta'=>['http_code'=>200]]);
    }

    public function verifyEmail(Request $request)
    {
        $messages = [
            'token.required'                => trans('user.token_required'),
            'userid.required'               => trans('user.userid_required')
        ];
        $rules = [
            'token' => 'required|string',
            'userid' => 'required|string'
        ];

        $validator          = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors()->first());
        }
        $user = \App\Models\User::where('id', '=', $request->get('userid'))->where('email_verify_token', '=', $request->get('token'))->where('email_verified', '=', 0)->first();
        if(!$user) {
            return $this->response->errorInternalError(trans('user.activation_link_expired'));
        }
        $user->email_verify_token = '';
        $user->email_verified = 1;
        try {
            $user->save();
        } catch (Exception $e) {
            return $this->response->errorInternalError('user.could_not_complete_user_profile');
        }
        return $this->response->withArray(['data' => $user, 'message' => trans('user.your_profile_completed_successfully'), 'meta'=>['http_code'=>200]]);
    }

    public function getUsers(Request $request)
    {
        $offset             =   $request->has('page')?($request->get('page')-1)*$request->get('limit'):0;
        $limit              =   $request->has('limit')?$request->get('limit'):10;
        $adminUser          =   JWTAuth::toUser($request->token);
        $users              =   \App\Models\User::where('creator', $adminUser->id)->orderBy('name', 'asc');
        
        $totalCount         =   $users->count();         
        $items              =   $users->limit($limit)->offset($offset)->with('role')->get();
        return $this->response->withArray(['data' => $items, 'total' => $totalCount, 'meta' => ['http_code'=>200]]);
    }

    public function UpdateUser(Request $request, $id)
    {   
        $messages = [
            'name.required'             => trans('user.name_requried'),
            'name.max'                  => trans('user.name_too_large')
        ];
        $rules = [
            'name' => 'required',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'mobile'=> 'required|numeric',
            'role' => 'required|exists:groups,id',
        ];
        
        $validator          = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors()->first());
        }
        $authUser   =   JWTAuth::toUser($request->token);
        $user       =   \App\Models\User::where('id', '=', $id)->first();
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->mobile = $request->get('mobile');
        $user->role = $request->get('role');
        $user->workstation_name = $request->get('workstation_name');
        if($request->get('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->get('password'));
        }
        try {
            $user->save();
        } catch (Exception $e) {
            return $this->response->errorInternalError('user.could_not_update_user');
        }
        return $this->response->withArray(['data' => $user, 'message' => trans('user.user_updated_successfully'), 'meta'=>['http_code'=>200]]);
    }

    public function removeUser(Request $request, $id)
    {
        $user = \App\Models\User::where('id', $id)->delete();
        return $this->response->withArray(['message' => trans('user.user_deleted_successfully'), 'meta' => ['http_code'=>200]]);
    }

    public function uploadProfilePicture(Request $request)
    {
        $picture = $request->file('file');
        if($picture) {
            $authUser   =   JWTAuth::toUser($request->token);
            $avatar_url = $picture->storeAs('avatars', $authUser->id);

            $user       =   \App\Models\User::where('id', '=', $authUser->id)->first();
            $user->avatar = $avatar_url;
            try {
                $user->save();
            } catch (Exception $e) {
                return $this->response->errorInternalError('user.could_not_update_user');
            }
            return $this->response->withArray(['data' => env('APP_STORAGE_URL').'storage/app/'.$user->avatar, 'message' => trans('user.user_profile_picture_upload_successfully'), 'meta'=>['http_code'=>200]]);
        } else {
            return $this->response->withArray(['data' => [], 'message' => trans('user.user_profile_picture_missing'), 'meta'=>['http_code'=>401]]);
        }
    }

}
