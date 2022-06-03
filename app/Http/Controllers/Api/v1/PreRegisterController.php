<?php

namespace App\Http\Controllers\Api\v1;


use App\Models\Visitor;
use App\Models\PreRegister;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\PreRegisterRequest;
use App\Http\Resources\v1\PreRegisterResources;
use App\Http\Services\PreRegister\PreRegisterService;


class PreRegisterController extends Controller
{
    use ApiResponse;

    protected $preRegisterService;


    public function __construct(PreRegisterService $preRegisterService)
    {
        $this->preRegisterService = $preRegisterService;

        $this->data['sitetitle'] = 'Pre-registers';
        // $this->middleware(['permission:pre-registers'])->only('index');
        $this->middleware(['permission:pre-registers_create'])->only('create', 'store');
        $this->middleware(['permission:pre-registers_edit'])->only('edit', 'update');
        $this->middleware(['permission:pre-registers_delete'])->only('destroy');
        $this->middleware(['permission:pre-registers_show'])->only('show');
    }
    public function index(Request $request)
    {
        try {

            $employees = PreRegisterResources::collection($this->preRegisterService->all($request));
            return $this->successResponse(['status' => 200, 'data' => $employees]);
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

    public function store(PreRegisterRequest $request)
    {

        $validator = new PreRegisterRequest();
        $validator = Validator::make($request->all(), $validator->rules());
        if (!$validator->fails()) {
            try {
                DB::beginTransaction();
                $this->preRegisterService->make($request);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->successResponse('Pre-Register saved');
        } else {
            return response()->json([
                'code'  => 422,
                'error' => $validator->errors(),
            ], 422);
        }
    }

    public function show($id)
    {
        $preregister = $this->preRegisterService->find($id);
        try {
            $preregister = new PreRegisterResources($preregister);
            return $this->successResponse(['status' => 200, 'data' => $preregister]);
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

    public function update(PreRegisterRequest $request, $id)
    {

        $validator = new PreRegisterRequest();
        $validator = Validator::make($request->all(), $validator->rules());
        if (!$validator->fails()) {
            try {
                DB::beginTransaction();
                $this->preRegisterService->update($request, $id);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->successResponse('Pre-Register Updated');
        } else {
            return response()->json([
                'code'  => 422,
                'error' => $validator->errors(),
            ], 422);
        }
    }

    public function destroy($id)
    {
        $preregister = PreRegister::where('id', $id)->first();
        if (!blank($preregister)) {
            try {
                $this->preRegisterService->delete($id);
            } catch (\Exception $e) {
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->successResponse('pre-register deleted');
        }
        return $this->errorResponse('You don\'t created Pre-register', 401);
    }


    public function check_pre_visitor(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => [
                    'required',
                ],
            ],
            [
                'email.required' => 'The email or phone field is required. ',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
            ], 422);
        }
        $visitor = Visitor::where([['is_pre_register', true], ['email', request()->email]])->orWhere([['is_pre_register', true], ['phone', request()->email]])->first();

        if (!empty($visitor)) {
            $visitor = new PreRegisterResources($visitor);
            return $this->successResponse(['status' => 200, 'data' => $visitor]);
        } else {
            return response()->json([
                'status'  => 422,
                'message' => 'Not Found',
            ], 422);
        }
    }
}
