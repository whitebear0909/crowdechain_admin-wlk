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

class AboutController extends BaseController
{
    public function __construct(Response $response) {
        $this->model = new \App\Models\About();
        parent::__construct($response);
    }
    
    public function getAboutus(Request $request)
    {
        $aboutus            =   \App\Models\About::first();
        
        return $this->response->withArray(['data' => $aboutus, 'meta' => ['http_code'=>200]]);
    }

    public function addAboutus(Request $request)
    {
        $messages = [
            'text.required'             => trans('user.text_requried')
        ];
        $rules = [
            'text' => 'required'
        ];

        $validator          = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors()->first());
        }
        $adminUser = JWTAuth::toUser($request->token);
        $about = new \App\Models\About;
        $about->fill([
            'text' => $request->get('text')
        ]);
        try {
            $about->save();
        } catch (Exception $e) {
            return $this->response->errorInternalError(trans('user.could_not_create_user'));
        }
        return $this->response->withArray(['data' => [], 'message' => trans('user.Aboutus_updated_successfully'), 'meta'=>['http_code'=>200]]);
    }

    public function updateAboutus(Request $request, $id)
    {
        $messages = [
            'text.required'             => trans('user.text_requried')
        ];
        $rules = [
            'text' => 'required'
        ];
        
        $validator          = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors()->first());
        }
        $authUser   =   JWTAuth::toUser($request->token);
        $about      =   \App\Models\About::where('id', '=', $id)->first();
        $about->text = $request->get('text');
        try {
            $about->save();
        } catch (Exception $e) {
            return $this->response->errorInternalError('user.could_not_update_user');
        }
        return $this->response->withArray(['data' => $about, 'message' => trans('user.About_updated_successfully'), 'meta'=>['http_code'=>200]]);
    }

}