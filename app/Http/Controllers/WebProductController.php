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
use \App\Models\TripadvisorReviews;
use \App\Models\TripadvisorOverall;
use \App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \App\Models\Product as Product;

class WebProductController extends BaseController
{
    public function __construct(Response $response) {
        $this->model = new \App\Models\Product();
        parent::__construct($response);
    }
    
    public function getAllProducts(Request $request , $type=null) {
        $offset             =   $request->has('page')?($request->get('page')-1)*$request->get('limit'):0;
        $limit              =   $request->has('limit')?$request->get('limit'):50;
        $products           =   \App\Models\Product::orderBy('priority', 'desc')
                                ->leftJoin('tripadvisor_overall', 'tripadvisor_overall.tour', '=', 'products.product_id');
        $products = ($type != null)?$products->where('is_tour','=',$type):$products;
        
        $totalCount         =   $products->count();         
        $items              =   $products->limit($limit)->offset($offset)->get();
        for ($i = 0; $i < count($items); $i++) {
            $items[$i]->logo = $items[$i]->logo ? (env('APP_STORAGE_URL').$items[$i]->logo) : '';
            $items[$i]->logo = Product::getInstanceImage($items[$i]->logo,"featured");
        }
        return $this->response->withArray(['data' => $items, 'total' => $totalCount, 'meta' => ['http_code'=>200]]);
    }

    public function getProductDetail(Request $request, $id)
    {
        $limit = 10;
        //$offset = 0;
        $product         =   \App\Models\Product::where('url_personalizzato', '=', $id)->first();
        $images          =   $product->images ? unserialize($product->images) : array();
        $finalImages     =  [];
        $finalIncludes   =  [];
        $product->logo = $product->logo ? (env('APP_STORAGE_URL').$product->logo) : '';
        $product->logo = Product::getInstanceImage($product->logo , "featured");
        for ($j = 0; $j < count($images); $j++) {
            $finalImages[$j] = Product::getInstanceImage(env('APP_STORAGE_URL').$images[$j],"medium");
        }
        $product->highlights = $product->highlights ? unserialize($product->highlights) : [];
        $product->fullitinerary = $product->fullitinerary ? unserialize($product->fullitinerary) : [];
        $product->things_to_note = $product->things_to_note ? unserialize($product->things_to_note) : [];
        $product->what_included = $product->what_included ? unserialize($product->what_included) : [];
        for ($k = 0; $k < count($product->what_included); $k++) {
            $finalIncludes[$k]['icon'] = env('APP_STORAGE_URL').$product->what_included[$k]['icon'];
            $finalIncludes[$k]['title'] = $product->what_included[$k]['title'];
        }
        $product->fullimgurl_img_meeting_point =($product->img_meeting_point!=null)?env('APP_STORAGE_URL').$product->img_meeting_point:"";


        // Get Reviews
        $product->tripadvisor_reviews = TripadvisorReviews::where('tour', '=', $product->product_id)->orderBy('id', 'desc')->limit($limit)
                                                            ->where('photo','!=','""')
                                                            ->where('author','!=','""')
                                                            ->get();
        $product->tripadvisor_overall = TripadvisorOverall::where('tour', '=', $product->product_id)->first();
        $product->what_included = $finalIncludes;
        $product->images = $finalImages;
        return $this->response->withArray(['data' => $product, 'message' => trans('product.product_detail_successfully'), 'meta'=>['http_code'=>200]]);
    }

    public function getReviews(Request $request){
        $limit = 10;
         // Get Reviews
        //  $tripadvisor_reviews = TripadvisorReviews::where('photo','!=','""')->orderBy('id', 'desc')->limit($limit)
        //  ->where('photo','!=','""')
        //  ->where('author','!=','""')
        //  ->get();

         $tripadvisor_reviews = DB::select(" select tripadvisor_reviews.* , products.name as tour_name , products.url_personalizzato
         from  products,tripadvisor_reviews  
         where products.product_id = tripadvisor_reviews.tour 
         and tripadvisor_reviews.author != '' 
         and author != ''    
         order BY tripadvisor_reviews.pub_date DESC      
         limit 10  ");

         return $this->response->withArray(['data' => $tripadvisor_reviews, 'message' => trans('product.product_detail_successfully'), 'meta'=>['http_code'=>200]]);

    }

    public function getTotalReviews(Request $request){

        $tripadvisor_total_reviews = DB::select("SELECT sum(reviews) as total_reviews  FROM tripadvisor_overall  ");
        return $this->response->withArray(['data' => $tripadvisor_total_reviews, 'message' => trans('product.product_detail_successfully'), 'meta'=>['http_code'=>200]]);


    }


    public function getTransaction(Request $request, $id)
    {
        $transaction         =   Transaction::where('transaction_code', '=', $id)->first();

        $transaction->transaction_info = $transaction->transaction_info ? unserialize($transaction->transaction_info) : [];
        $transaction->customer = $transaction->customer_cart ? unserialize($transaction->customer_cart) : [];
        
        return $this->response->withArray(['data' => $transaction, 'message' => trans('product.product_detail_successfully'), 'meta'=>['http_code'=>200]]);
    }

}
