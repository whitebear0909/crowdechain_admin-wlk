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

class FaqController extends BaseController
{
    public function __construct(Response $response) {
        $this->model = new \App\Models\Faq();
        parent::__construct($response);
    }
    
    public function getAllFaqs(Request $request , $id='') {
        
        $faqs =   \App\Models\Faq::orderBy('question', 'asc')
        ->whereNull('product_filter')
        ->orWhere('product_filter', '=', '');
        if($id!=''){
            $product         =   \App\Models\Product::where('url_personalizzato', '=', $id)->first();
            $faqs = $faqs->orWhere('product_filter', 'like', '%' ."$product->product_id". ';%');
        }
        $faqs = $faqs->get();
        
        return $this->response->withArray(['data' => $faqs, 'total' => count($faqs), 'meta' => ['http_code'=>200]]);
    }

    public function getFaqList(Request $request)
    {
        $offset             =   $request->has('page')?($request->get('page')-1)*$request->get('limit'):0;
        $limit              =   $request->has('limit')?$request->get('limit'):10;
       // $adminUser          =   JWTAuth::toUser($request->token);
        $faqs               =   \App\Models\Faq::orderBy('question', 'asc');
        
        $totalCount         =   $faqs->count();         
        //$items              =   $faqs->limit($limit)->offset($offset)->get();
        $items  = $faqs->get();
        return $this->response->withArray(['data' => $items, 'total' => $totalCount, 'meta' => ['http_code'=>200]]);
    }

    public function addFaq(Request $request)
    {
        $messages = [
            'question.required'          => trans('user.question_requried'),
            'answer.required'            => trans('user.answer_required'),
        ];
        $rules = [
            'question' => 'required',
            'answer' => 'required'
        ];

        $validator          = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors()->first());
        }
        $adminUser = JWTAuth::toUser($request->token);
        $faq = new \App\Models\Faq;
        $faq->fill([
            'question' => $request->get('question'),
            'answer' => $request->get('answer'),
            'product_filter'=>$request->get('product_filter')
        ]);
        try {
            $faq->save();
        } catch (Exception $e) {
            return $this->response->errorInternalError(trans('user.could_not_create_user'));
        }
        return $this->response->withArray(['data' => [], 'message' => trans('user.user_created_successfully'), 'meta'=>['http_code'=>200]]);
    }

    public function updateFaq(Request $request, $id)
    {   
        $messages = [
            'question.required'          => trans('user.question_requried'),
            'answer.required'            => trans('user.answer_required'),
        ];
        $rules = [
            'question' => 'required',
            'answer' => 'required'
        ];
        
        $validator          = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors()->first());
        }
        $authUser   =   JWTAuth::toUser($request->token);
        $faq       =   \App\Models\Faq::where('id', '=', $id)->first();
        $faq->question = $request->get('question');
        $faq->answer = $request->get('answer');
        $faq->product_filter = $request->get('product_filter');
        try {
            $faq->save();
        } catch (Exception $e) {
            return $this->response->errorInternalError('user.could_not_update_faq');
        }
        return $this->response->withArray(['data' => $faq, 'message' => trans('user.faq_updated_successfully'), 'meta'=>['http_code'=>200]]);
    }

    public function getFaq(Request $request, $id)
    {
        $faq        =   \App\Models\Faq::where('id', '=', $id)->first();
        return $this->response->withArray(['data' => $faq, 'message' => trans('user.faq_updated_successfully'), 'meta'=>['http_code'=>200]]);
    }

    public function deleteFaq(Request $request, $id)
    {
        $faq = \App\Models\Faq::where('id', $id)->delete();
        return $this->response->withArray(['message' => trans('user.Faq_deleted_successfully'), 'meta' => ['http_code'=>200]]);
    }

}
