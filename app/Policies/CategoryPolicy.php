<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

/** Category Policy — سياسات التصنيف */
class CategoryPolicy
{
    // Anyone can view lists/details — السماح للجميع بالعرض
    public function viewAny(?User $user): bool { return true; }
    public function view(?User $user, Category $category): bool { return true; }

    // Admin only for mutations — التعديلات للمشرف فقط
    public function create(User $user): bool { return $user->hasRole('admin'); }
    public function update(User $user, Category $category): bool { return $user->hasRole('admin'); }
    public function delete(User $user, Category $category): bool { return $user->hasRole('admin'); }
}
