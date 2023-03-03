<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Core\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Core\LogRequest;
use App\Services\Core\LogManageService;

class LogsController extends Controller
{

    private $logManageService;

    public function __construct(LogManageService $logManageService)
    {
        $this->logManageService = $logManageService;
    }

    public function index(LogRequest $request)
    {
        $response = $this->logManageService->getLogData($request->all());
        if($response[STATUS_CODE_KEY] == config('configuration.software_exception_code.success')){
            return view('core.logs.index', $response);
        }
        return redirect()->back()->withErrors('Something went wrong')->withInput();
    }
}
