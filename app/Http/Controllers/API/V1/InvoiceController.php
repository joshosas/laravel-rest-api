<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Filters\V1\InvoiceFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Resources\V1\InvoiceResource;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\V1\InvoiceCollection;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\V1\InvoiceCollection
     */
    public function index(Request $request)
    {
        // Instantiate CustomerFilter to filter request parameters
        $filter = new InvoiceFilter();

        // Transform request parameters into Eloquent query format
        $queryItems = $filter->transform($request); // [['column', 'operator', 'value']]

        // Check if any query conditions are generated
        if (count($queryItems) == 0) {
            // If no conditions, return paginated collection of all customers
            return new InvoiceCollection(Invoice::paginate(10));
        } else {
            // If conditions exist, filter Invoices and return paginated collection
            $invoices = Invoice::where($queryItems)->paginate(10);

            return new InvoiceCollection($invoices->appends($request->query()));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceRequest  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
