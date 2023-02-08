<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidateUniqueLeaderOfDepartment;

class AssignMemberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'role_id' => ['required', new ValidateUniqueLeaderOfDepartment(request()->department_id)],
            'user_id' => ['required'],
            'department_id' => ['required'],
        ];
    }
}
