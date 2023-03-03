<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RequestParamaterFormation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // IF REQUEST HAS daterange variable it will convert the date data and merge it on request parameter

        $date_from = Carbon::now()->subDays(30)->format('Y/m/d');
        $date_to = Carbon::now()->format('Y/m/d');
        $page_limit = DATA_TABLES_PAGINATION_LIMIT;

        if($request->has('daterange')){

            $date = explode(DATE_RANGE_SEPARATOR, $request->daterange);

            if(isset($date[0])){
                $date_from = Carbon::parse($date[0])->format('Y-m-d');
            }

            if(isset($date[1])){
                $date_to = Carbon::parse($date[1])->format('Y-m-d');
            }

        }

        if($request->has('page_limit')){
            $page_limit = $request->page_limit;
        }

        $request->merge([
            'date_from' => $date_from,
            'date_to' => $date_to,
            'page_limit' => $page_limit,
            'created_by' => auth()->check() ? auth()->user()->id : null,
        ]);
        
        return $next($request);
    }
}
