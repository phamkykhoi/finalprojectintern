<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (! array_key_exists('name', $this->all()) && ! array_key_exists('description', $this->all()) && ! array_key_exists('task_group_id', $this->all())) {
            return [
                'is_quickly' => ['boolean'],
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