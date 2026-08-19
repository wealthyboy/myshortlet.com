<?php

namespace App\Support;

class ChannexTaskIds
{
    public static function extract(array $response): array
    {
        $ids = collect([
            data_get($response, 'task_id'),
            data_get($response, 'task.id'),
            data_get($response, 'meta.task_id'),
            data_get($response, 'data.id'),
            data_get($response, 'data.attributes.id'),
            data_get($response, 'data.attributes.task_id'),
        ]);

        $taskIds = data_get($response, 'task_ids', []);
        if (is_array($taskIds)) {
            $ids = $ids->merge($taskIds);
        }

        $data = data_get($response, 'data', []);
        if (is_array($data) && array_is_list($data)) {
            foreach ($data as $item) {
                $ids->push(data_get($item, 'id'));
                $ids->push(data_get($item, 'attributes.id'));
                $ids->push(data_get($item, 'attributes.task_id'));
            }
        }

        return $ids
            ->filter(fn ($id) => is_string($id) && trim($id) !== '')
            ->map(fn ($id) => trim($id))
            ->unique()
            ->values()
            ->all();
    }
}