<?php

namespace App\Filters;

// ApiFilter.php



use Illuminate\Http\Request;

class ApiFilter
{

    protected $safeParams = [];

    protected $columnMap = [];

    protected $operatorMap = [];

    // Transform request parameters into Eloquent query format
    public function transform(Request $request)
    {
        $eloquentQuery = [];

        foreach ($this->safeParams as $param => $operators) {
            $query = $request->query($param);

            // Skip parameters that are not set in the request
            if (!isset($query)) {
                continue;
            }

            // Map parameter to its corresponding column name if needed
            $column = $this->columnMap[$param] ?? $param;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    // Add condition to Eloquent query array
                    $eloquentQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        return $eloquentQuery;
    }
}
