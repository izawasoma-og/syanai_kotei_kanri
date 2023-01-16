<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class passChar implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        //半角英数字のみ許可します
        return preg_match('/^[a-zA-Z0-9]+$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "パスワードに使用できる文字は半角英数字のみです";
    }
}
