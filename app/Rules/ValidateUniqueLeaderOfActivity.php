<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\UserActivityRepository;

class ValidateUniqueLeaderOfActivity implements Rule
{
    protected $activityId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($activityId)
    {
        $this->activityId = $activityId;
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
        if ($value == 1 && app(UserActivityRepository::class)->existLeader($this->activityId)) {
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
        return 'Activity này đã có chủ, không thể thêm!';
    }
}
