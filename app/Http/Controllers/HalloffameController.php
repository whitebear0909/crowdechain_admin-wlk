<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use \App\Models\Halloffame;
use App\Helpers\CommonHelper;
use JWTAuth;
use Carbon\Carbon;
use Auth;
use App;
use Mail;


class HalloffameController extends BaseController
{
    public function __construct(Response $response) {
        parent::__construct($response);
    }
    
    public function index(Request $request ) {
        // $offset =   $request->has('page')?($request->get('page')-1)*$request->get('limit'):0;
        // $limit =   $request->has('limit')?$request->get('limit'):1000;
        $offset = 0;
        $limit = 1000;
        $halloffames =   Halloffame::orderBy('home_order', 'asc')
        ->orderBy('id', 'desc');
        if($request->has('home')){
            $halloffames = $halloffames->where('home_order', '>', '0');
        }

        $totalCount         =   $halloffames->count();         
        $items              =   $halloffames->limit($limit)->offset($offset)->get();


        for($i = 0; $i < count($items); $i++){
            $items[$i]->fullimgurl = env('APP_STORAGE_URL').$items[$i]->img;
            $items[$i]->fullimgurl  = \App\Models\Product::getInstanceImage($items[$i]->fullimgurl , "featured");
        }

        return $this->response->withArray(['data' => $items, 'total' => $totalCount, 'meta' => ['http_code'=>200]]);
    }

    public function search(Request $request , $id ='') {
        $offset =   $request->has('page')?($request->get('page')-1)*$request->get('limit'):0;
        $limit =   $request->has('limit')?$request->get('limit'):10;
        $halloffames =   Halloffame::whereNull('product_filter')
        ->orWhere('product_filter', '=', '')
        ->orderBy('product_filter', 'desc');
        if($id!=''){
            $product =   \App\Models\Product::where('url_personalizzato', '=', $id)->first();
            $halloffames = $halloffames->orWhere('product_filter', 'like', '%' ."$product->product_id". ';%');
        }        
        $halloffames = $halloffames->orderBy('id', 'desc');

        $totalCount         =   $halloffames->count();         
        $items              =   $halloffames->limit($limit)->offset($offset)->get();


        for($i = 0; $i < count($items); $i++){
            $items[$i]->fullimgurl = env('APP_STORAGE_URL').$items[$i]->img;
            $items[$i]->fullimgurl  = \App\Models\Product::getInstanceImage($items[$i]->fullimgurl , "featured");
        }

        return $this->response->withArray(['data' => $items, 'total' => $totalCount, 'meta' => ['http_code'=>200]]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $halloffame = $request->isMethod('put') ? Halloffame::findOrFail($request->halloffame_id) : new Halloffame;

        $halloffame->id = $request->input('halloffame_id');
        $halloffame->title = $request->input('title');
        $halloffame->property_alt = $request->input('property_alt');
        $halloffame->author = $request->input('author');
        $halloffame->instagram_url = $request->input('instagram_url');
        $halloffame->home_order = $request->input('home_order');
        

        $halloffame->img = $request->input('img');
        $halloffame->product_filter = $request->input('product_filter');

        try {
           $data =  $halloffame->save();
           return $this->response->withArray(['data' => $data,  'meta' => ['http_code'=>200]]);

        } catch (Exception $e) {
            return $this->response->errorInternalError(trans('product.could_not_create_product'));
        }

        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get article
        $halloffame = Halloffame::findOrFail($id);

        try {
            $data =  $halloffame->delete();
            return $this->response->withArray(['data' => $data,  'meta' => ['http_code'=>200]]);
 
         } catch (Exception $e) {
             return $this->response->errorInternalError(trans('product.could_not_create_product'));
         }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get article
        $halloffame = Halloffame::findOrFail($id);
        $halloffame->fullimgurl = env('APP_STORAGE_URL').$halloffame->img;


         return $this->response->withArray(['data' => $halloffame, 'message' => trans('product.product_detail_successfully'), 'meta'=>['http_code'=>200]]);
    }


   

}
