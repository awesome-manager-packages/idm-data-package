<?php

namespace AwesomeManager\IdmData\Client\Models;

use Awesome\Foundation\Traits\Models\HasUuid;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Support\Arr;

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
    
    public function isAdmin(): bool
    {
        return $this->hasRoles('admin');
    }

    public function getAccessPages(): array
    {
        return collect($this->roles)->pluck('access_groups.*.pages')->flatten()->unique()->all();
    }

    public function checkAccessPage(string $page): bool
    {
        return in_array($page, $this->getAccessPages());
    }

    public function getAccessGroups(string $accessPage): array
    {
        return collect($this->roles)->map(function (array $role) use ($accessPage) {
            foreach ($role['access_groups'] as $accessGroup) {
                if (in_array($accessPage, $accessGroup['pages'])) {
                    return $accessGroup;
                }
            }
        })->all();
    }

    public function getFilters(string $entity): array
    {
        return collect($this->roles)->map(function (array $role) use ($entity) {
            foreach ($role['filters'] as $filter) {
                if ($filter['entity_type'] === $entity) {
                    return $filter['entity_ids'];
                }
            }
        })->flatten()->unique()->all();
    }

    public function hasRoles(string ...$roleCode): bool
    {
        return collect($this->roles)->filter(fn($role) => in_array($role['code'], $roleCode))->isNotEmpty();
    }
}
