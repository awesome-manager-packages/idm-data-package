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

    public function getRoles(): array
    {
        return $this->prepareRoles($this->roles);
    }

    private function prepareRoles(array $roles): array
    {
        if (empty($roles)) {
            return [];
        }

        $result = [];

        foreach ($roles as $role) {
            $result[] = $this->prepareRole($role);
        }

        return $result;
    }

    private function prepareRole(array $role): array
    {
        if (empty($role)) {
            return [];
        }

        $res = [
            'id' => $role['id'],
            'name' => $role['name'],
            'code' => $role['code'],
            'entity_type' => $role['pivot']['entity_type'],
            'entity_id' => $role['pivot']['entity_id'],
        ];

        $accessGroupPages = $this->prepareAccessGroupsPages($role['access_groups']);

        return array_merge($res, ['access_pages' => $accessGroupPages]);
    }

    private function prepareAccessGroupsPages(array $accessGroups): array
    {
        if (empty($accessGroups)) {
            return [];
        }

        $accessGroupPages = [];
        foreach ($accessGroups as $accessGroup) {
            if (!empty($accessGroup['access_group_pages'])) {
                foreach ($accessGroup['access_group_pages'] as $accessGroupPage) {
                    $accessGroupPages[] = $accessGroupPage['site_page_code'];
                }
            }
        }

        return $accessGroupPages;
    }
}
