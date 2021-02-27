<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Toyyibpay;

class ToyyibPayController extends Controller
{
    public function createBill(){
        Toyyibpay::createBill($code, $bill_object);
    }
}
