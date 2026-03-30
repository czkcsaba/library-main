<?php

namespace App\Api;

use App\Models\CategoryModel;

class CategoryApiController extends EntityApiController
{
    public function __construct()
    {
        parent::__construct(new CategoryModel());
    }

    protected function serializeOne(mixed $item): array
    {
        /** @var CategoryModel $item */
        return [
            'id' => (int)$item->id,
            'name' => (string)$item->name,
        ];
    }

    protected function fill(mixed $item, array $data): void
    {
        /** @var CategoryModel $item */
        if (isset($data['name'])) $item->name = (string)$data['name'];
    }
}
