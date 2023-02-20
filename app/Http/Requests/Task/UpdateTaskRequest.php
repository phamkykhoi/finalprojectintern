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
        return [
            'name' => ['required'],
            'description' => ['required'],
            'task_group_id' => ['required'],
        ];
    }

    public function passes()
    {
        if (! array_key_exists('name', $this->all())) {
            unset($this->validator->getData()['name']);
            unset($this->validator->getData()['description']);
            unset($this->validator->getData()['task_group_id']);
            return true;
        }

        return parent::passes();
    }
}