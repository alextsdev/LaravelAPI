<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\V3\V3\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/categories",
 *     tags={"Categories"},
 *     summary="Get list all categories",
 *     @OA\Response(
 *         response=200,
 *         description="List of categories",
 *     ),
 *     @OA\Response(
 *     response=401,
 *     description="Unauthorized"
 *      ),
 *     @OA\Response(
 *     response=403,
 *     description="Forbidden"
 *      )
 * )
 */
class CategoryController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->tokenCan('categories-list'), 403);

        return CategoryResource::class::collection(Category::all());
    }

    public function show(Category $category)
    {
        //abort_if(!auth()->user()->tokenCan('categories-show'), 403);

        return new CategoryResource($category);
    }

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
