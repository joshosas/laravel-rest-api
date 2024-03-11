<?php

namespace App\Filters\V1;

// CustomerFilter.php



use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class CustomerFilter extends ApiFilter
{
    // Define safe parameters and their allowed operators
    protected $safeParams = [
        'name' => ['eq'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
        'zipCode' => ['eq', 'gt', 'lt']
    ];

    // Map query parameters to database column names
    protected $columnMap = [
        'zipCode' => 'zip_code'
    ];

    // Map query operators to Eloquent operators
    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '≤',
        'gt' => '>',
        'gte' => '≥'
    ];
}
