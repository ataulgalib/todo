<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\SensetiveDataManipulationTrait;

class RequestParameter
{
    use SensetiveDataManipulationTrait;

    /**
     * Handle an incoming request.
     * When do you need to manipulate the request data, Here is the input field parameter.
     */
    public $list_of_sensetive_parameter = [
        'card_no',
        'card_number',
        'card_pin',
        'card_cvv',
        'card_expiry_date',
        'card_expiry_month',
        'card_expiry_year',
        'card_name',
        'card_type',
        'card_holder_name',
    ];

    /**
     * Handle an incoming request to store in log.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $request_data = $this->removeSensitiveData($request->all(), $assign_log = true);
        //logCreate($request_data);
        return $next($request);
    }
}
