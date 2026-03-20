<?php

namespace App\Scopes;

use Auth;
use App;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class IsActiveScope implements Scope
{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::guard('admin')->user() ?? (Auth::check() ? Auth::user() : null);
        if ($user && method_exists($user, 'hasRole') && ($user->hasRole('SUPER_ADMIN') || $user->hasRole('SUB_ADMIN'))) {
            return;
        }
        $builder->where('is_active', '=', '1');
    }

}