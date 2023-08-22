<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use ReCaptcha\ReCaptcha;

class RecaptchaRule implements Rule
{

    protected $token = '6LeNYo4UAAAAABuDPoujL7HOhVDEClUm7OylY7wx';

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

      $recaptcha = new ReCaptcha($this->token);

      $resp = $recaptcha->setExpectedHostname(env('APP_DOMAIN'))
                        ->verify($value, $_SERVER['REMOTE_ADDR']);

      if ($resp->isSuccess()) {
          return true;
      }

      return $resp->getErrorCodes();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Подтвердите что вы не робот';
    }
}
