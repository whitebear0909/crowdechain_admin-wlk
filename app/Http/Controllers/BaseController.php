<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use EllipseSynergie\ApiResponse\Contracts\Response;

class BaseController extends Controller
{

    protected $response;
    
    public function __construct(Response $response, $options = []) {
        $this->response = $response;
    }
}
