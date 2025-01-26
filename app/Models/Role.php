<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends SpatieRole
{
    use SoftDeletes;

    protected $table = 'spatie_roles';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'guard_name'
    ];
}