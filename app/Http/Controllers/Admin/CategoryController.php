<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService) {}

    public function index(Request $request)
    {
        $categories = $this->categoryService->getAll($request->query('keyword'));
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateCategory($request);

        $this->categoryService->create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Thêm danh mục mới thành công!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $this->validateCategory($request, $category->id);

        $this->categoryService->update($category, $validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy(Category $category)
    {
        try {
            $this->categoryService->delete($category);
            return redirect()->route('admin.categories.index')
                ->with('success', 'Đã xóa danh mục thành công!');
        } catch (Exception $e) {
            return redirect()->route('admin.categories.index')
                ->with('error', $e->getMessage());
        }
    }

    private function validateCategory(Request $request, ?int $categoryId = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('categories', 'name')->ignore($categoryId),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'name.required'      => 'Vui lòng nhập tên danh mục.',
            'name.string'        => 'Tên danh mục phải là chuỗi ký tự hợp lệ.',
            'name.max'           => 'Tên danh mục không được vượt quá 150 ký tự.',
            'name.unique'        => 'Tên danh mục này đã tồn tại.',
            'description.string' => 'Mô tả danh mục phải là chuỗi ký tự hợp lệ.',
            'description.max'    => 'Mô tả danh mục không được vượt quá 1000 ký tự.',
        ]);
    }
}