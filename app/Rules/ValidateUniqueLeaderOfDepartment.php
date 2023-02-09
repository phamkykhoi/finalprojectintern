<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\UserDepartmentRepository;

class ValidateUniqueLeaderOfDepartment implements Rule
{
    protected $departmentId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($departmentId)
    {
        $this->departmentId = $departmentId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($value == 1 && app(UserDepartmentRepository::class)->existLeader($this->departmentId)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Phòng này đã có trưởng phòng, không thể thêm!';
    }
}
