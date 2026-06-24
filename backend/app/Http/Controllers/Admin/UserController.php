<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.users.index', [
            'users' => User::withCount('orders')
                ->where('is_admin', false)
                ->latest()
                ->paginate(12),
        ]);
    }
}
