<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Backend\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $service) {}

    public function index()
    {
        $users = $this->service->all();
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {
        $user->status = $user->status ? 0 : 1;
        $user->save();

        $message = $user->status ? 'تم فك الحظر بنجاح' : 'تم الحظر بنجاح';
        return redirect()->back()->with('success', $message);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('status', 'تم حذف المستخدم بنجاح');
    }
}
