<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Membership portal subdomain
    |--------------------------------------------------------------------------
    | The domain on which the membership portal (login, MFA, iframe) is served.
    | Set MEMBERSHIP_DOMAIN in .env to override.
    */
    'domain' => env('MEMBERSHIP_DOMAIN', 'membership.avarewase.com'),

    /*
    |--------------------------------------------------------------------------
    | Iframe URL
    |--------------------------------------------------------------------------
    | The external URL embedded in the portal after login + MFA succeed.
    | Set MEMBERSHIP_IFRAME_URL in .env once known.
    */
    'iframe_url' => env('MEMBERSHIP_IFRAME_URL'),

];
