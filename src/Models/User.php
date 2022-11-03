<?php

namespace AwesomeManager\IdmData\Client\Models;

use Awesome\Foundation\Traits\Models\HasUuid;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasUuid;

    protected $fillable = [
        'name',
        'surname',
        'second_name',
        'email',
        'phone'
    ];

    protected $hidden = [
        'password',
    ];
}
