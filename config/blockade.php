<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Blockade key
    |--------------------------------------------------------------------------
    |
    | This value sets the name of the HTTP request parameter to which the
    | code is assigned when making a request. E.g. if the key is `dev`
    | and code is `letmein`, your request would be /page?dev=letmein.
    |
    */
    'key' => 'dev',

    /*
    |--------------------------------------------------------------------------
    | Blockade code
    |--------------------------------------------------------------------------
    |
    | The main pass code that is required to pass the blockade. If using
    | multiple pass codes, this must be a comma-separated list (defined
    | as a single string). Set to `false` to disable blockade.
    |
    */
    'code' => env('BLOCKADE_CODE', false),

    /*
    |--------------------------------------------------------------------------
    | Allow multiple codes
    |--------------------------------------------------------------------------
    |
    | Whether or not to allow multiple codes to be set. If true, the codes
    | must be specified as a single string containing a comma-delimited
    | list. Codes are trimmed before comparison.
    |
    */
    'multiple_codes' => env('BLOCKADE_MULTIPLE_CODES', false),

    /*
    |--------------------------------------------------------------------------
    | Show form on blocked view
    |--------------------------------------------------------------------------
    |
    | Whether or not to show a password text input for bypassing the blockade
    | on the blocked view. If disabled, you can still pass the blockade by
    | appending the code to the URL (see Blockade key above).
    |
    */
    'show_form' => false,

    /*
    |--------------------------------------------------------------------------
    | Redirect when blocked
    |--------------------------------------------------------------------------
    |
    | Providing this will redirect the visitor to a different page/site when
    | they have not provided the blockade code in the url.
    |
    */
    'redirect' => env('BLOCKADE_REDIRECT', null),

    /*
    |--------------------------------------------------------------------------
    | Redirect when blocked
    |--------------------------------------------------------------------------
    |
    | Providing this will redirect the visitor following any other rules until
    | this time has passed.  Date must be parsable by the date() function.
    |
    */
    'until' => env('BLOCKADE_UNTIL', null),

    /*
    |--------------------------------------------------------------------------
    | Not-blocked list
    |--------------------------------------------------------------------------
    |
    | The URLs excluded from the blockade (so will never be blocked). Should
    | be an array of strings, and may use wildcard patterns.
    |
    */
    'not_blocked' => [],

    /*
    |--------------------------------------------------------------------------
    | Not-forced-secure list
    |--------------------------------------------------------------------------
    |
    | The URLs excluded from the force-secure checks. Should be an array of
    | strings, and may use wildcard patterns.
    |
    */
    'not_secure' => [],
];
