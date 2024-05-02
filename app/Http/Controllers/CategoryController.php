<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\CategoryDto;
use App\DataTransferObjects\DataTableRequestDto;
use App\Http\Requests\DataTableAjaxRequest;
use App\Http\Requests\Web\Category\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct(protected CategoryService $service){
        //
    }

    public function index(){
        $data['title'] = 'Category';
        return view('admin.category.index' ,$data);
    }

    public function list(DataTableAjaxRequest $request){
        $dt = DataTableRequestDto::fromDataTableAjaxRequest($request);

        return response()->json($this->service->dataTableIndex($dt));
    }
    public function show(Category $category){
        return response()->json([
            'category' => $category
        ]);
    }

    public function store(CategoryRequest $request){
        $this->service->store(CategoryDto::fromCategoryRequest($request));

        return response()->json([
            'type' => 'success',
        ]);
    }

    public function update(CategoryRequest $request, Category $category){
        $this->service->update($category, CategoryDto::fromCategoryRequest($request));

        return response()->json([
            'type' => 'success',
        ]);
    }

    public function delete(Category $category){
        $this->service->delete($category);
        return response()->json([
            'type' => 'success',
        ]);
    }
}
