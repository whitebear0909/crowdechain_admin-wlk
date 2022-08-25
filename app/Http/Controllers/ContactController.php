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

class ContactController extends BaseController
{
    public function __construct(Response $response) {
        $this->model = new \App\Models\Faq();
        parent::__construct($response);
    }

    public function contactUs(Request $request)
    {
        $messages = [
            'name.required'             => trans('user.name_requried'),
            'email.required'            => trans('user.email_required'),
            'email.email'               => trans('user.email_invalid'),
            'message.required'          => trans('user.message_requried')
        ];
        $rules = [
            'name' => 'required',
            'email' => 'required|string|email|max:255',
            'message' => 'required',
        ];

        $validator          = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors()->first());
        }
        try {
            $body = trans('user.contactemailbody');
            $body2 = array();
            $body2['toname'] = 'Info Walkabout';
            //$body2['toemail'] = 'info@walkabout.com'; 
            $body2['toemail'] = 'info@walkaboutflorence.com'; 

            //$body2['tocc'] = 'yiresse.abia@gmail.com';
            $body2['name'] = $request->get('name');
            $body2['email'] = $request->get('email');
            $body2['message'] = $request->get('message');
            Mail::send('emails.contact', ['body' => $body, 'body2' => $body2], function ($m) use ($body, $body2) {
                $m->to($body2['toemail'], $body2['toname'])->subject(trans('user.user_contact_message'));
                //$m->cc($body2['tocc']);


            });
        } catch (Exception $e) {
            return $this->response->errorInternalError(trans('user.server_internal_server'));
        }
        return $this->response->withArray(['data' => [], 'message' => trans('user.thank_message_sent_successfully'), 'meta'=>['http_code'=>200]]);
    }

}
