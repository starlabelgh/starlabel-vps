<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Http\Resources\v1\EmployeeResources;
use App\Http\Services\Employee\EmployeeService;
use App\Traits\ApiResponse;


class EmployeeController extends Controller
{
    use ApiResponse;

    protected $employeeService;


    public function __construct(EmployeeService $employeeService)
    {
        $this->data['sitetitle'] = 'Employees';
        // $this->middleware('auth:api');
        // $this->middleware(['permission:employees'])->only('index');
        // $this->middleware(['permission:employees_show'])->only('show');

        $this->employeeService = $employeeService;
    }
    public function index()
    {
        try {
            $employees = EmployeeResources::collection($this->employeeService->all());
            return $this->successResponse(['status' => 200, 'data' => $employees]);
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

    public function show($id)
    {
        $employee = $this->employeeService->find($id);
        try {
            $employee = new EmployeeResources($employee);
            return $this->successResponse(['status' => 200, 'data' => $employee]);
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }
}
