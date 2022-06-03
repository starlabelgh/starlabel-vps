<?php

namespace App\Http\Services\PreRegister;

use App\Enums\Status;
use App\Http\Requests\PreRegisterRequest;
use App\Models\PreRegister;
use App\Models\Visitor;
use App\Notifications\SendInvitationToVisitors;
use App\Notifications\SendVisitorToEmployee;
use Illuminate\Http\Request;
use DB;

class PreRegisterService
{

    public function all()
    {
        // TODO fixing 
        /* Todo:turag */
         
        // if(auth()->user()->getrole->name == 'Employee') {
        //     return PreRegister::where(['employee_id'=>auth()->user()->employee->id])->orderBy('id', 'desc')->get();
        // }else {
        //     return PreRegister::orderBy('id', 'desc')->get();
        // }
        return PreRegister::orderBy('id', 'desc')->get();

    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        if(auth()->user()->getrole->name == 'Employee') {
            return PreRegister::where(['id'=>$id,'employee_id'=>auth()->user()->employee->id])->first();
        }else {
            return PreRegister::find($id);
        }
    }

    /**
     * @param $column
     * @param $value
     * @return mixed
     */
    public function findWhere($column, $value)
    {
        $result = PreRegister::where($column, $value)->get();

        return $result;
    }

    /**
     * @param $column
     * @param $value
     * @return mixed
     */
    public function findWhereFirst($column, $value)
    {
        $result = PreRegister::where($column, $value)->first();

        return $result;
    }

    /**
     * @param int $perPage
     * @return mixed
     */
    public function paginate($perPage = 10)
    {
        return PreRegister::paginate($perPage);
    }

    /**
     * @param PreRegisterRequest $request
     * @return mixed
     */
    public function make($request)
    {
        $input['first_name'] = $request->input('first_name');
        $input['last_name'] = $request->input('last_name');
        $input['email'] = $request->input('email');
        $input['phone'] = $request->input('phone');
        $input['gender'] = $request->input('gender');
        $input['address'] = $request->input('address');
        $input['is_pre_register'] = true;
        $input['status'] = Status::ACTIVE;
        $visitor = Visitor::create($input);
        $result='';
        if($visitor) {
            $preArray['expected_date']  = $request->input('expected_date');
            $preArray['expected_time']  = date('H:i:s', strtotime($request->input('expected_time')));
            $preArray['comment']        = $request->input('comment');
            $preArray['visitor_id']     = $visitor->id;
            $preArray['employee_id']     = $request->input('employee_id');
            $result = PreRegister::create($preArray);
            try {
                $result->visitor->notify(new SendInvitationToVisitors($result));
            } catch (\Exception $e) {
                // Using a generic exception
            }
        }
        return $result;

    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $pre_register = PreRegister::findOrFail($id);

        $input['first_name'] = $request->input('first_name');
        $input['last_name'] = $request->input('last_name');
        $input['email'] = $request->input('email');
        $input['phone'] = $request->input('phone');
        $input['gender'] = $request->input('gender');
        $input['address'] = $request->input('address');
        $input['employee_id'] = $request->input('employee_id');
        $input['is_pre_register'] = true;
        $input['status'] = Status::ACTIVE;
        $pre_register->visitor->update($input);
        if($pre_register) {
            $preArray['expected_date']  = $request->input('expected_date');
            $preArray['expected_time']  = date('H:i:s', strtotime($request->input('expected_time')));
            $preArray['comment']        = $request->input('comment');
            $preArray['employee_id'] = $request->input('employee_id');
            $pre_register->update($preArray);
            try {
                $pre_register->visitor->notify(new SendInvitationToVisitors($pre_register));
            } catch (\Exception $e) {
                // Using a generic exception
            }
        }
        return $pre_register;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        try {
            $PreRegister = PreRegister::find($id);
            $PreRegister->visitor->delete();
            $PreRegister->delete();
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

}
