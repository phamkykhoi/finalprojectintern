<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CreateSubTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $request = request()->all();
        return [
            'name' => [ 'required',
                Rule::unique('tasks')->where(function ($query) use ($request) {
                    return $query->where('parent_id', $request['parent_id']);
                })->ignore($this->route('subtask')),
            ],
            'description' => ['nullable'],
        ];
    }
}
