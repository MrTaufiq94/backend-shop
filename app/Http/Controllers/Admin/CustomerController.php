<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
    * index
    *
    * @return void
    */
    public function index()
    {
        $customers = Customer::latest()->when(request()->q, function($customers) {
            $customers = $customers->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.customer.index', compact('customers'));
    }
}
