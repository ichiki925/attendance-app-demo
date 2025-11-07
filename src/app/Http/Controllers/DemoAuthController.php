<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class DemoAuthController extends Controller
{
    /**
     * 管理者デモアカウントで自動ログイン
     */
    public function loginAsAdmin()
    {
        $admin = User::where('email', 'admin@example.com')->first();

        if ($admin) {
            // デモアカウントの当日データをリセット
            $this->resetTodayAttendance($admin->id);
            Auth::login($admin);
            return redirect()->route('admin.attendance.list');
        }

        return redirect('/login')->with('error', 'デモアカウントが見つかりません');
    }

    /**
     * 一般ユーザーデモアカウントで自動ログイン
     */
    public function loginAsUser()
    {
        $user = User::where('email', 'user@example.com')->first();

        if ($user) {
            // デモアカウントの当日データをリセット
            $this->resetTodayAttendance($user->id);
            Auth::login($user);
            return redirect()->route('attendance.list');
        }

        return redirect('/login')->with('error', 'デモアカウントが見つかりません');
    }

    /**
     * 当日の勤怠データをリセット
     */
    private function resetTodayAttendance($userId)
    {
        $today = Carbon::today();

        // 当日の勤怠データを削除
        Attendance::where('user_id', $userId)
            ->whereDate('date', $today)
            ->delete();
    }
}