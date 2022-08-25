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
use App\Models\Transaction;


class ExternalApiController extends BaseController
{
    public  $base_external_url ;
    public $blog_url ;
    public $guides_url;



    public function __construct(Response $response)
    {
        parent::__construct($response);
        $this->base_external_url = env('BASE_EXTERNAL_URL');
        $this->blog_url = env('BASE_ARTICLES_URL');
        $this->guides_url = env('BASE_GUIDES_URL');

    }
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function getPossiblePartecipants(Request $request, $id)
    {
        $url = $this->base_external_url . "/product/participants/$id";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);
        $max_array = $this->getMaxAvailability($data);

        return $this->response->withArray(["max" => $max_array, "data" => $data["data"], 'meta' => ['http_code' => 200]]);
    }

    public function hasVehicle(Request $request, $id, $adults, $youths, $children, $date = "")
    {
        $date = "";

        $url = $this->base_external_url . "product/hasvehicle/$id/$adults/$youths/$children";
        $url = ($date == "") ? $url : $url . "/" . $date;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);

        $hasVehicle = $this->hasVehicleBool($data);

        return $this->response->withArray(["hasVehicle" => $hasVehicle, "data" => $data["data"], 'meta' => ['http_code' => 200]]);
    }

    public function getMaxAvailability(array $data)
    {

        // Code to get the max from the data give
        $max_array  = ["maxAdult" => 2, "maxYoung" => 4, "maxChild" => 4];
        return $max_array;
    }

    public function hasVehicleBool(array $data = null)
    {
        // Code to check if has vehicle
        return true;
    }

    /**
     * Get info about availability
     */
    public function getVariation(Request $request, $id, $day, $adults, $youths, $children)
    {

        $url = $this->base_external_url . "product/getvariations/$id/$day/$adults/$youths/$children";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);


        return $this->response->withArray(["data" => $data, 'meta' => ['http_code' => 200]]);
    }

    public function getAvailabityByDay(Request $request, $id, $date){

        $url = $this->base_external_url . "product/getavailabilitybyday/$id/$date";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);

        $data_tmp =  $data;
        $data_return = [];
        foreach ($data_tmp   as $key => $value) {
            # code...
            $data_tmp[$key]["dayhour"] = $data_tmp[$key]["dayhour"];
            $data_return[] = $data_tmp[$key];
        }


        return $this->response->withArray(["data" => $data_return, 'meta' => ['http_code' => 200]]);



    }

    /**
     * Get info about the calendar
     */
    public function getCalendar(Request $request, $id, $month = 1 , $year  = null)
    {
        $year = ($year==null)?date("Y"):$year;

        $url = $this->base_external_url . "product/getcalendar/$id/$year-$month-01/$year-$month-31";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);


        return $this->response->withArray(["data" => $data, 'meta' => ['http_code' => 200]]);
    }

    /**
     * Get info about the calendar
     */
    public function storecart(Request $request)
    {

        $data = json_encode($request->all());
        //$data->host = $_SERVER['REMOTE_ADDR'];
        $url = $this->base_external_url . "order/storecart";
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);



        $data = json_decode($response, true);
        $transaction = $this->createTransaction($request->all(), $data);
        $data['transaction_code'] = $transaction->transaction_code;




        return $this->response->withArray(["data" => $data, 'meta' => ['http_code' => 200]]);
    }

        /**
     * Get info about the calendar
     */
    public function updatecart(Request $request , $id)
    {

        $data = json_encode($request->all());

        $transaction      =   Transaction::where('transaction_code', '=', $id)->first();
        $url = $this->base_external_url . "order/storecart";
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);


        $data = json_decode($response, true);
        if(isset($data["codiceTransazione"])){
            $transaction->fill([
                'transaction_info' => serialize($data),
                'APIKEY' => $data['APIKEY'],
                'timestamp' => $data['timestamp'],
                'divisa' => $data['divisa'],
                'amount' => $data['amount'],
                'codiceTransazione' => $data['codiceTransazione'],
                'mac' => $data['mac'],
                'status' => Transaction::$STARTED,
                'transaction_code' => $id
            ]);
            $transaction->save();

        }

       // $transaction = $this->createTransaction($request->all(), $data);
        //$data['transaction_code'] = $transaction->transaction_code;




        return $this->response->withArray(["data" => $data, 'meta' => ['http_code' => 200]]);
    }


    public function createTransaction($transaction_info, $data)
    {

        $transaction = new Transaction();

        $transaction->fill([
            'transaction_info' => serialize($transaction_info),
            'APIKEY' => $data['APIKEY'],
            'timestamp' => $data['timestamp'],
            'divisa' => ($data['divisa'])?$data['divisa']:$transaction_info['variation']['currency'],
            'amount' => $data['amount'],
            'codiceTransazione' => $data['codiceTransazione'],
            'mac' => $data['mac'],
            'status' => Transaction::$STARTED,
            'transaction_code' => sha1($data['codiceTransazione'])
        ]);

        try {
            $transaction->save();
        } catch (Exception $e) {
            return $this->response->errorInternalError(trans('product.could_not_create_product'));
        }
        return $transaction;
    }

    /**
     * Get detail of product
     */
    public function getProduct(Request $request, $id)
    {

        $url = $this->base_external_url . "product/edit/" . $id;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);


        return $this->response->withArray(["data" => $data, 'meta' => ['http_code' => 200]]);
    }

    /**
     * Get all products
     */
    public function getProducts(Request $request)
    {

        $url = $this->base_external_url . "products";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);


        return $this->response->withArray(["data" => $data["data"], 'meta' => ['http_code' => 200]]);
    }

    /**
     * Get detail of partecipants
     */
    public function getPartecipants(Request $request, $id)
    {

        $url = $this->base_external_url . "product/participants/" . $id;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);


        return $this->response->withArray(["data" => $data["data"], 'meta' => ['http_code' => 200]]);
    }

    public function searchProducts(Request $request, $date, $adults, $youths, $children)
    {


        $url = $this->base_external_url . "product/search/$date/$adults/$youths/$children";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);

        $data_tmp =  $data['data'];
        $data_return = [];
        foreach ($data_tmp   as $key => $value) {
            # code...
            $data_tmp[$key]["product_id"] = $data_tmp[$key]["product_data"]["id"];
            $data_return[] = $data_tmp[$key];
        }

        return $this->response->withArray(["data" => $data_return, 'meta' => ['http_code' => 200]]);
    }

    public function updateTransaction(Request $request, $id)
    {

        $transaction      =   Transaction::where('transaction_code', '=', $id)->first();
        $status = $request->get('status');

        switch ($status) {
            case 'APPROVED':
                # code...
                $status = Transaction::$APPROVED;
                break;
            case 'DENIED':
                # code...
                $status = Transaction::$DENIED;
                break;
            case 'INPROGRESS':
                # code...
                $status = Transaction::$INPROGRESS;
                break;

            default:
                # code...
                $status = Transaction::$PENDING;
                break;
        }


        $transaction->status = $status;
        $transaction->paypal_response  = $request->get('paypal_response') ? serialize($request->get('paypal_response')) : null;
        $transaction->nexi_response  = $request->get('nexi_response') ? serialize($request->get('nexi_response')) : null;

        if ($request->get('paypal_response')) {
            $url = $this->base_external_url . "paypal/ipn/" . $transaction->codiceTransazione;
            $data = $request->get('paypal_response');
        } elseif ($request->get('nexi_response')) {
            $url = $this->base_external_url . "nexi/ipn/" . $transaction->codiceTransazione;
            $data = $request->get('nexi_response');
        }

        $data = json_encode($data);
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), true);

        //Result case based on payal or 

        if ($request->get('nexi_response')) {
            $transaction->status = ($response["esito"] == "OK") ? Transaction::$APPROVED : Transaction::$DENIED;
        } elseif ($request->get('paypal_response')) {
            $transaction->status = $status;
        }

        try {
            $transaction->save();
        } catch (Exception $e) {
            return $this->response->errorInternalError(trans('product.could_not_create_product'));
        }
        // Hit the service from Michele
        return $this->response->withArray(["data" => ["transaction" => $transaction, "response" => $response], 'meta' => ['http_code' => 200]]);
    }

    /**
     * To conclude the transaction
     */
    public function updateCustomerCart(Request $request, $id)
    {

        $transaction      =   Transaction::where('transaction_code', '=', $id)->first();
        $url = $this->base_external_url . "order/updatecustomercart/" . $transaction->codiceTransazione;
        $transaction->customer_cart  = $request->get('customer_cart') ? serialize($request->get('customer_cart')) : null;
        $transaction->save();

        $data = json_encode($request->get('customer_cart'));
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), true);

        return $this->response->withArray(["data" => ["transaction" => $transaction, "response" => $response], 'meta' => ['http_code' => 200]]);
    }

    public function printVoucher(Request $request, $id){

        $url = $this->base_voucher_get.$id;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);



        return $this->response->withArray(["data" => $data, 'meta' => ['http_code' => 200]]);

    }

    public function expertGuides(){
        $url = $this->guides_url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);



        return $this->response->withArray(["data" => $data, 'meta' => ['http_code' => 200]]);
        
    }

    public function blogs(){
        $url = $this->blog_url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);



        return $this->response->withArray(["data" => $data, 'meta' => ['http_code' => 200]]);
        
    }


    
}
