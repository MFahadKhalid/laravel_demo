<?php

namespace App\DataTransferObjects;

use App\Http\Requests\Web\Category\CategoryRequest;

class CategoryDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $status,
    ) {}
    public static function fromCategoryRequest(CategoryRequest $request){
        return new self(
            name: $request->validated('name'),
            status: $request->validated('status'),
        );
    }
    public function arrayForModel() : array {
        return [
            'name' => $this->name,
            'status' => $this->status,
        ];
    }
}
