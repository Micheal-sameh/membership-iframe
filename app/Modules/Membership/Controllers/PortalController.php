<?php

declare(strict_types=1);

namespace App\Modules\Membership\Controllers;

use App\Http\Controllers\Controller;

class PortalController extends Controller
{
    public function index()
    {
        return view('membership.portal', [
            'iframeUrl' => config('membership.iframe_url'),
        ]);
    }
}
