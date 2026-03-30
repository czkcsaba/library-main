<?php

namespace App\Api;

use App\Models\Model;

abstract class EntityApiController extends ApiController
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index(): void
    {
        $q = $this->query();
        $orderBy = $q['order_by'] ?? null;
        $direction = $q['direction'] ?? null;

        $items = $this->model->all([
            'order_by' => is_array($orderBy) ? $orderBy : (is_string($orderBy) ? [$orderBy] : []),
            'direction' => is_array($direction) ? $direction : (is_string($direction) ? [$direction] : []),
        ]);

        ApiResponse::ok($this->serializeMany($items));
    }

    public function show(int $id): void
    {
        $item = $this->model->find($id);
        if (!$item) {
            ApiResponse::fail("Not found", 404);
        }
        ApiResponse::ok($this->serializeOne($item));
    }

    public function create(): void
    {
        $data = $this->body();
        $this->fill($this->model, $data);

        $newId = $this->model->create();
        if (!$newId) {
            ApiResponse::fail("Create failed", 500, $_SESSION['error_message'] ?? null);
        }
        ApiResponse::ok(['id' => (int)$newId], 201);
    }

    public function update(int $id): void
    {
        $item = $this->model->find($id);
        if (!$item) {
            ApiResponse::fail("Not found", 404);
        }

        $data = $this->body();
        $this->fill($item, $data);

        $ok = $item->update();
        if (!$ok) {
            ApiResponse::fail("Update failed", 500, $_SESSION['error_message'] ?? null);
        }
        ApiResponse::ok(['updated' => true]);
    }

    public function delete(int $id): void
    {
        $item = $this->model->find($id);
        if (!$item) {
            ApiResponse::fail("Not found", 404);
        }

        $ok = $item->delete();
        if (!$ok) {
            ApiResponse::fail("Delete failed", 500, $_SESSION['error_message'] ?? null);
        }
        ApiResponse::ok(['deleted' => true]);
    }

    protected function serializeMany(array $items): array
    {
        $out = [];
        foreach ($items as $it) $out[] = $this->serializeOne($it);
        return $out;
    }

    abstract protected function serializeOne(mixed $item): array;

    /**
     * Fill model properties from request data. Implemented by child.
     */
    abstract protected function fill(mixed $item, array $data): void;
}
