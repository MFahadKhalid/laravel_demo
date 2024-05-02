<?php

namespace App\Services;

use App\DataTransferObjects\CategoryDto;
use App\DataTransferObjects\DataTableRequestDto;
use App\Models\Category;



class CategoryService
{
    private static $search_cols = [
        'name',
        'status',
    ];
    private static $order_cols = [
        'name',
        'status',
    ];
    public function dataTableIndex(DataTableRequestDto $dto): array {
        $category_count = Category::count();
        $categories = Category::query();
        if($dto->search['value'] != ''){
            foreach ($dto->columns as $col) {
                if(in_array($col['data'], self::$search_cols)){
                    $categories = $categories->orWhere($col['data'], 'like', "%".$dto->search['value']."%");
                }
            }
        }
        foreach ($dto->order as $order_type) {
            $col = $dto->columns[$order_type['column']]['data'];
            if(in_array($col, self::$order_cols)){
                $categories = $categories->orderBy($col, $order_type['dir']);
            }
        }
        $filtered_count = $categories->count();
        $categories = $categories->skip($dto->start)->take($dto->length)->get();
        $categories->map(function ($category) {
            $category->action = view('pages.category.action', ['category_id' => $category->id])->render();
        });
        return [
            'categories' => $categories,
            'draw' => $dto->draw,
            'recordsTotal' => $category_count,
            'recordsFiltered' => $filtered_count,
        ];
    }
    public function store(CategoryDto $dto) : Category {
        return Category::create($dto->arrayForModel());
    }
    public function update(Category $category, CategoryDto $dto): Category {
        return tap($category)->update($dto->arrayForModel());
    }
    public function delete(Category $category): bool{
        return $category->delete();
    }
}
