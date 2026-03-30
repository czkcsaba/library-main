<?php

namespace App\Api;

use App\Models\PublisherModel;

class PublisherApiController extends EntityApiController
{
    public function __construct()
    {
        parent::__construct(new PublisherModel());
    }

    protected function serializeOne(mixed $item): array
    {
        /** @var PublisherModel $item */
        return [
            'id' => (int)$item->id,
            'name' => (string)$item->name,
        ];
    }

    protected function fill(mixed $item, array $data): void
    {
        /** @var PublisherModel $item */
        if (isset($data['name'])) $item->name = (string)$data['name'];
    }
}
