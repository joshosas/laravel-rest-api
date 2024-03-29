<?php

// CustomerController.php

namespace App\Http\Controllers\API\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Filters\V1\CustomerFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Requests\V1\UpdateCustomerRequest;
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
        $customers = Customer::where($filterItems);

        if ($includeInvoices) {
            $customers = $customers->with('invoices');
        }

        return new CustomerCollection($customers->paginate(10)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response|\App\Http\Resources\V1\CustomerResource

     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified customer resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response|\App\Http\Resources\V1\CustomerResource
     */

    public function show(Customer $customer)
    {
        $includeInvoices = request()->query('includeInvoices');

        if ($includeInvoices) {
            return new CustomerResource($customer->loadMissing('invoices'));
        }

        // Add a return statement in case $includeInvoices is false or not set
        return new CustomerResource($customer);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
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
