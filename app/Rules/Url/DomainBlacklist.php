<?php

namespace App\Rules\Url;

use App\Helpers\Helper;
use Illuminate\Contracts\Validation\Rule;

class DomainBlacklist implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $blackLists = config('urlhub.domain_blacklist');
        $longUrl = rtrim($value, '/');
        $a = true;

        foreach ($blackLists as $blackList) {
            $blackList = Helper::urlSanitize($blackList);
            $segment1 = '://'.$blackList.'/';
            $segment2 = '://www.'.$blackList.'/';

            if (strstr($longUrl, $segment1) || strstr($longUrl, $segment2)) {
                $a = false;
            }
        }

        return $a;
    }

    /**
     * Get the validation error message.
     *
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function message()
    {
        return 'Sorry, the URL you entered is on our internal blacklist. It may have been used abusively in the past, or it may link to another URL redirection service.';
    }
}