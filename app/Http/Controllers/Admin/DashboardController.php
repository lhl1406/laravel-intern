<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Redirect screen A-01-Use
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return redirect()->route('admin.user.index');
    }
}
