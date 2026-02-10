<?php

namespace App\Services\Channex;

class GroupService extends ChannexClient
{
    public function list()
    {
        return $this->get('/groups');
    }

    public function getById(string $groupId)
    {
        return $this->get("/groups/{$groupId}");
    }

    public function create(string $title)
    {
        return $this->post('/groups', [
            'group' => [
                'title' => $title,
            ],
        ]);
    }

    public function update(string $groupId, string $title)
    {
        return $this->put("/groups/{$groupId}", [
            'group' => [
                'title' => $title,
            ],
        ]);
    }

    public function delete(string $groupId)
    {
        return $this->delete("/groups/{$groupId}");
    }

    public function attachProperty(string $groupId, string $propertyId)
    {
        return $this->post("/groups/{$groupId}/properties/{$propertyId}");
    }

    public function detachProperty(string $groupId, string $propertyId)
    {
        return $this->delete("/groups/{$groupId}/properties/{$propertyId}");
    }
}
