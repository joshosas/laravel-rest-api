<?php

// CustomerController.php

namespace App\Http\Controllers\API\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Filters\V1\CustomerFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\V1\CustomerCollection;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\V1\CustomerCollection
     */
    public function index(Request $request)
    {
        // Instantiate CustomerFilter to filter request parameters
        $filter = new CustomerFilter();

        // Transform request parameters into Eloquent query format
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $includeInvoices = $request->query('includeInvoices');

        // Filter customers and return paginated collection
        $customers = Customer::where($filterItems)->paginate(10);

        if ($includeInvoices) {
            $customers = $customers->with('invoices');
        }

        return new CustomerCollection($customers->appends($request->query()));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\V1\CustomerCollection
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
