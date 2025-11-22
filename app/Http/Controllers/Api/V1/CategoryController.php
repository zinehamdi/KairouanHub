<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseApiController
{
	/**
	 * List all active categories.
	 */
	public function index()
	{
		$categories = Category::where('is_active', true)
			->orderBy('position')
			->withCount('services')
			->get();

		return $this->successResponse(CategoryResource::collection($categories));
	}

	/**
	 * Show a specific category.
	 */
	public function show($id)
	{
		$category = Category::where('is_active', true)
			->withCount('services')
			->findOrFail($id);

		return $this->successResponse(new CategoryResource($category));
	}
}
