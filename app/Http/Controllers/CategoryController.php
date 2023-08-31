<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $lang_file = 'admin.category_details.';

    public function index(): Factory|View|Application
    {
        return view('categories.overview', ["categories" => Category::all()]);
    }

    public function create(): Factory|View|Application
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            'name' => ['required', 'max:50', 'unique:categories'],
            'description' => ['nullable', 'max:5000'],
            'images' => ['nullable', 'array', 'max:1'],
        ]);

        // reset image name if no image is uploaded
        $attributes['img_name'] = null;
        if (isset($request['images'])) {
            $attributes['img_name'] = $request['images'][0]->getClientOriginalName();
        }

        if ($request->has('images')) {
            // Upload images that aren't already in the project
            UploadController::uploadImages($request);
        }

        $newCategory = Category::create($attributes);

        if ($request->has('archived')) {
            $newCategory->archived = date('Y-m-d h:i:s');
        } else {
            $newCategory->archived = null;
        }

        $newCategory->save();

        return redirect()->route('category_details', ['category' => $newCategory]);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Application|Factory|View
     */
    public function show(Category $category): View|Factory|Application
    {
        $category_id = $category->id;
        $assignedProducts = Product::filterCategory($category_id)->orderBy('name', 'asc')->get();
        $allProducts = Product::orderBy('name', 'asc')->get();
        $unAssignedProducts = $allProducts->diff($assignedProducts);

        return view('categories.details', [
            "category" => Category::firstWhere('id', "=", $category_id), 'assignedProducts' => $assignedProducts, 'unAssignedProducts' => $unAssignedProducts
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Application|Factory|View
     */
    public function edit(Category $category): View|Factory|Application
    {
        return view('categories.edit', [
            "category" => Category::find($category->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Category $category
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Category $category, Request $request): RedirectResponse
    {
        if ($request->has('delete')) {
            ProductCategory::where('category_id', $category->id)
                ->delete();
            return $this->destroy($category);
        }

        $attributes = $request->validate([
            'name' => ['required', 'max:50', 'unique:categories,name,' . $category->id],
            'description' => ['nullable', 'max:5000'],
            'images' => ['nullable', 'array', 'max:1']
        ]);

        // reset image name if no image is uploaded
        $attributes['img_name'] = null;
        if (isset($request['images'])) {
            $attributes['img_name'] = $request['images'][0]->getClientOriginalName();
        }

        if ($request->has('archived')) {
            $category->archived = date('Y-m-d h:i:s');
        } else {
            $category->archived = null;
        }

        $category->update($attributes);

        if ($request->has('images')) {
            // Upload images that aren't already in the project
            UploadController::uploadImages($request);
        }

        return redirect()->route('category_details', ['category' => $category]);
    }


    public function addProduct(Request $request): JsonResponse|RedirectResponse
    {
        $productId = $request->input('productId');
        $categoryId = $request->input('categoryId');
        ProductCategory::create([
            'product_id' => $productId,
            'category_id' => $categoryId
        ]);
        return response()->json(['message' => __($this->lang_file . 'json_item_added_succes')]);
    }

    public function deleteProduct(Request $request)
    {
        $productId = $request->input('productId');
        $categoryId = $request->input('categoryId');
        $category = Category::firstWhere('id', "=", $categoryId);
        try {
            ProductCategory::where('product_id', $productId)
                ->where('category_id', $categoryId)
                ->delete();

            return response()->json(['message' => __($this->lang_file . 'json_item_deleted_succes')]);
        } catch (QueryException) {
            return redirect()->route('category_details', ['category' => $category])->with('error', __($this->lang_file . 'item_deleted_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        try {
            $category->delete();
            return redirect()->route('category_overview');
        } catch (QueryException) {
            return redirect()->route('category_edit', ['category' => $category])->with('error', __($this->lang_file . 'category_deleted_error'));
        }
    }
}

