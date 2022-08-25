<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CommonHelper;
use JWTAuth;
use Carbon\Carbon;
use Auth;
use App;
use App\Models\Product;
use Mail;
use Image;

class ProductController extends BaseController
{
    public function __construct(Response $response) {
        $this->model = new \App\Models\Product();
        parent::__construct($response);
    }
    
    public function getAllProducts(Request $request) {
        $offset             =   $request->has('page')?($request->get('page')-1)*$request->get('limit'):0;
        $limit              =   $request->has('limit')?$request->get('limit'):50;
        $products           =   \App\Models\Product::orderBy('priority', 'desc');
        
        $totalCount         =   $products->count();         
        $items              =   $products->limit($limit)->offset($offset)->get();
        for ($i = 0; $i < count($items); $i++) {
            $items[$i]->images = $items[$i]->images?unserialize($items[$i]->images) : [];
            $items[$i]->logo = $items[$i]->logo ? (env('APP_STORAGE_URL').$items[$i]->logo)  : '';
            $items[$i]->logo = Product::getInstanceImage($items[$i]->logo,"featured");
        }
        return $this->response->withArray(['data' => $items, 'total' => $totalCount, 'meta' => ['http_code'=>200]]);
    }

    public function addProduct(Request $request)
    {
        $messages = [
            'product_id.required'          => trans('product.product_id_requried'),
            'product_code.required'        => trans('product.product_code_required'),
            'name.required'                => trans('product.name_required'),
            'description.required'         => trans('product.description_required')
        ];
        $rules = [
            'product_id' => 'required',
            'product_code' => 'required',
            'name' => 'required',
            'description' => 'required'
        ];

        $validator          = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors()->first());
        }
        $adminUser = JWTAuth::toUser($request->token);
        $product = new \App\Models\Product;
        $product->fill([
            'product_id' => $request->get('product_id'),
            'product_code' => $request->get('product_code'),
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'claim' => $request->get('claim'),
            'logo' => $request->get('images') ? $request->get('images')[0] : null,
            'images' => $request->get('images') ? serialize($request->get('images')) : null,
            'meta_title' => $request->get('meta_title'), 
            'meta_description' => $request->get('meta_description'), 
            'meta_keyphrases'  => $request->get('meta_keyphrases'),
            'url_personalizzato'  => $request->get('url_personalizzato'),
            'meta_keywords'  => $request->get('meta_keywords'),
            'is_tour'  => $request->get('is_tour'),
            'priority'=> $request->get('priority'),
            'why_us'=>$request->get('why_us'),
            'special_claim'=>$request->get('special_claim'),
            'special_claim_type'=>$request->get('special_claim_type'),
            'private_tour'=>$request->get('private_tour'),

        ]);
        try {
            $product->save();
        } catch (Exception $e) {
            return $this->response->errorInternalError(trans('product.could_not_create_product'));
        }
        return $this->response->withArray(['data' => [], 'message' => trans('product.product_created_successfully'), 'meta'=>['http_code'=>200]]);
    }

    public function updateProduct(Request $request, $id)
    {
        $messages = [
            'product_id.required'          => trans('product.product_id_requried'),
            'product_code.required'        => trans('product.product_code_required'),
            'name.required'                => trans('product.name_required'),
            'description.required'         => trans('product.description_required')
        ];
        $rules = [
            'product_id' => 'required',
            'product_code' => 'required',
            'name' => 'required',
            'description' => 'required'
        ];
        
        $validator          = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors()->first());
        }
        $authUser   =   JWTAuth::toUser($request->token);
        $product       =   \App\Models\Product::where('id', '=', $id)->first();
        $product->product_id = $request->get('product_id');
        $product->product_code = $request->get('product_code');
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->is_tour  = $request->get('is_tour');
        $product->priority =  $request->get('priority');
        $product->claim =  $request->get('claim');
        $product->special_claim = $request->get('special_claim');
        $product->special_claim_type = $request->get('special_claim_type');
        $product->why_us = $request->get('why_us');

        //Meta section
        $product->meta_title = $request->get('meta_title');
        $product->meta_description = $request->get('meta_description');
        $product->meta_keyphrases = $request->get('meta_keyphrases');
        $product->url_personalizzato = $request->get('url_personalizzato');
        $product->meta_keywords = $request->get('meta_keywords');

        //youtubee url
        $product->url_youtube_slider = $request->get('url_youtube_slider');

        //Private tour
        $product->private_tour =$request->get('private_tour');

        //Meeting Point
        
        $product->description_meeting_point = $request->get('description_meeting_point');
        $product->img_meeting_point = $request->get('img_meeting_point');
        $product->lat = $request->get('lat');
        $product->lon = $request->get('lon');


        $product->highlights = $request->get('highlights') ? serialize($request->get('highlights')) : null;
        $product->fullitinerary = $request->get('fullitinerary')  ? serialize($request->get('fullitinerary')) : null;
        $product->things_to_note = $request->get('things_to_note')  ? serialize($request->get('things_to_note')) : null;
        $product->what_included = $request->get('what_included')  ? serialize($request->get('what_included')) : null;
        
        if($request->get('logo_src')&& $request->get('logo_src')!=''){
            $product->logo = $request->get('logo_src');
        }else{
            $product->logo = $request->get('images') ? $request->get('images')[0] : null;    
        }
        
        $product->images = $request->get('images') ? serialize($request->get('images')) : null;
        try {
            $product->save();
        } catch (Exception $e) {
            return $this->response->errorInternalError('product.could_not_update_product');
        }
        return $this->response->withArray(['data' => $product, 'message' => trans('product.product_updated_successfully'), 'meta'=>['http_code'=>200]]);
    }

    public function getProductDetail(Request $request, $id)
    {
        $product         =   \App\Models\Product::where('id', '=', $id)->first();
        $images          =   $product->images ? unserialize($product->images) : array();
        $finalImages     =  [];

        $product->logo_src = $product->logo ? ($product->logo) : '';
        $product->logo = $product->logo ? (env('APP_STORAGE_URL').$product->logo) : '';

        
        for ($j = 0; $j < count($images); $j++) {
            $finalImages[$j] = env('APP_STORAGE_URL').$images[$j];
        }

        $product->fullimgurl_img_meeting_point =($product->img_meeting_point!=null)?env('APP_STORAGE_URL').$product->img_meeting_point:"";
        $product->images = $images;
        $product->highlights = $product->highlights ? unserialize($product->highlights) : [];
        $product->fullitinerary = $product->fullitinerary ? unserialize($product->fullitinerary) : [];
        $product->things_to_note = $product->things_to_note ? unserialize($product->things_to_note) : [];
        $product->what_included = $product->what_included ? unserialize($product->what_included) : [];
        $product->fullImages = $finalImages;

        
        return $this->response->withArray(['data' => $product, 'message' => trans('product.product_detail_successfully'), 'meta'=>['http_code'=>200]]);
    }

    public function deleteProduct(Request $request, $id)
    {
        $product = \App\Models\Product::where('id', $id)->delete();
        return $this->response->withArray(['message' => trans('product.product_deleted_successfully'), 'meta' => ['http_code'=>200]]);
    }

    public function uploadImageFile(Request $request)
    {
        $picture = $request->file('file');
        $fileurl = '';
        if($picture) {
            try {
                $timestamp  =   Carbon::now()->timestamp;
                $name   =   $timestamp.'_product_'.$picture->getFileName();
                $filename = $name.".".$picture->getClientOriginalExtension();
                $path       =   $picture->storeAs('public/product_images', $filename);
 

                // $destinationPath = storage_path().'/public/product_images/'.$name."_s.".$picture->getClientOriginalExtension();

                $destinationPathSmall = public_path('product_images/small/');
                $destinationPathMedium = public_path('product_images/medium/');
                $destinationPathFeatured= public_path('product_images/featured/');
                


                $img = Image::make($picture->getRealPath());

                // Creation of two instances 
                $width_small = 100; 
                $height_small = 100; 

                $width_featured = 400; 
                $height_featured = 400; 

                $width_medium = 800; 
                $height__medium = 640; 
                
                if($img->width() > $img->height() ){

                    $img->resize(null, $height_featured, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPathFeatured.$filename);

                    $img->resize(null, $height_small, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPathSmall.$filename);
                }else{
                    $img->resize($width_featured, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPathFeatured.$filename);

                    $img->resize($width_small, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPathSmall.$filename);
                }

                $img = Image::make($picture->getRealPath());
                if($img->width() >  $width_medium && $img->height() > $height__medium  ){
                    $img->resize($width_medium, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($destinationPathMedium.$filename);
                }else{
                    $img->save($destinationPathMedium.$filename);
                }

                $fileurl    =   "product_images/$filename";


            } catch (Exception $e) {
                return $this->response->errorInternalError('product.error_in_upload_imagefile');
            }
            return $this->response->withArray(['data' => $fileurl, 'message' => trans('product.file_upload_successfully'), 'meta'=>['http_code'=>200]]);
        } else {
            return $this->response->withArray(['data' => [], 'message' => trans('product.upload_file_missing'), 'meta'=>['http_code'=>401]]);
        }
    }

    

}
