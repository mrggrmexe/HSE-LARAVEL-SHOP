<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FeedbackMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users_count' => User::query()->count(),
            'products_count' => Product::query()->count(),
            'categories_count' => Category::query()->count(),
            'orders_count' => Order::query()->count(),
            'new_feedback_count' => FeedbackMessage::query()
                ->where('status', FeedbackMessage::STATUS_NEW)
                ->count(),
        ];

        $recentOrders = Order::query()
            ->with('user')
            ->latest('ordered_at')
            ->limit(10)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
        ]);
    }
}