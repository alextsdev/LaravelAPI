<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Str;
use Knuckles\Scribe\Attributes\Endpoint;

/**
 * @group Categories
 *
 * Managing categories
 *
 * @queryParam page int The page number. Defaults to 1.
 */
class CategoryController extends Controller
{
    /**
     * Get all categories
     *
     * Getting the list of the categories
     */

    public function index()
    {
        abort_if(!auth()->user()->tokenCan('categories-list'), 403);

        return CategoryResource::class::collection(Category::all());
    }

    #[Endpoint('Show category', description: 'Get a category by ID')]
    public function show(Category $category)
    {
        abort_if(!auth()->user()->tokenCan('categories-show'), 403);

        return new CategoryResource($category);
    }

    /**
     * Store a new category
     *
     * Creating a new category
     *
     * @bodyParam name string required The name of the category. Example: Electronics
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = Str::uuid() . '.' . $file->extension();
            $file->storeAs('categories', $name, 'public');
            $data['photo'] = $name;
        }

        $category = Category::create($data);

        return new CategoryResource($category);
    }

    public function update(Category $category, StoreCategoryRequest $request)
    {
        $category->update($request->all());

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        //return response(null, Response::HTTP_NO_CONTENT);
        return response()->noContent();
    }

    public function list()
    {
        return CategoryResource::collection(Category::all());
    }

}
