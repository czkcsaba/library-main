<?php

namespace App\Api;

use App\Models\WriterModel;

class WriterApiController extends EntityApiController
{
    public function __construct()
    {
        parent::__construct(new WriterModel());
    }

    protected function serializeOne(mixed $item): array
    {
        /** @var WriterModel $item */
        return [
            'id' => (int)$item->id,
            'name' => (string)$item->name,
            'bio' => (string)$item->bio,
        ];
    }

    protected function fill(mixed $item, array $data): void
    {
        /** @var WriterModel $item */
        if (isset($data['name'])) $item->name = (string)$data['name'];
        if (isset($data['bio'])) $item->bio = (string)$data['bio'];
    }
}
