<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    const STATUS_TYPE_QUICKLY = 'quickly';

    const STATUS_TYPE_IMPORTANT = 'important';

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (request()-> change_status_type === static:: STATUS_TYPE_QUICKLY)  {
            return [
                'is_quickly' => ['boolean'],
            ];
        }

        if (request()-> change_status_type === static:: STATUS_TYPE_IMPORTANT)  {
            return [
                'is_important' => ['boolean'],
            ];
        }

        return [
            'name' => ['required'],
            'description' => ['required'],
            'task_group_id' => ['required'],
        ];
    }

}