<?php

namespace App\Http\Requests\Activity;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidateUniqueLeaderOfActivity;

class AssignMemberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'role_id' => ['required', new ValidateUniqueLeaderOfActivity(request()->activity_id)],
            'user_id' => ['required'],
            'activity_id' => ['required'],
        ];
    }
}
