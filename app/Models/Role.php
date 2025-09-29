<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Permission\Models\Role as SpatieRole;
class Role extends SpatieRole
{
    protected $fillable = ['name', 'guard_name'];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst(strtolower($value)),
            set: fn(string $value) => ucfirst(strtolower($value))
        );
    }
}
