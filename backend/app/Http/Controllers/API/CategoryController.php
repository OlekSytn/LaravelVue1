<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

class CategoryController extends BaseController
{
    /**
     * @group Category
     * 
     * Category List
     * @authenticated
     * @header Authorization Bearer token
     * 
     * @response 200{
     *       "success": true,
     *       "status_code": 200,
     *       "message": "Category fetch successfully.",
     *       "data": [
     *           {
     *              "id": 2,
     *               "name": "Iphone 14",
     *               "created_at": "22nd September, 2022"
     *           }
     *       ]
     *   }
     */
    public function index()
    {
        try{
            $categories =  CategoryResource::collection(Category::all());
            return $this->sendResponse( 'Category fetch successfully.', $categories);
        }catch(Exception $e){
            return $this->sendError($e->getMessage(), [], 500);  
        }      
        
    }


    /**
     * @group Category
     * 
     * Add Category
     * @authenticated
     * @header Authorization Bearer token
     * 
     * @bodyParam  name string required. Example: iphone
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response 200{
     *       "success": true,
     *       "status_code": 201,
     *       "message": "Category created successfully."
     *   }
     */
    public function store(CreateCategoryRequest $request)
    {
        try{
            Category::create([
                "name" => $request->input('name')
            ]);
            return $this->sendResponse( 'Category created successfully.', [], 201);
        }catch(Exception $e){
            return $this->sendError($e->getMessage(), [], 500);  
        }
    }

    
     /**
     * @group Category
     * 
     * Show Single Category
     * @authenticated
     * @header Authorization Bearer token
     * 
     * @urlParam id required This id require for fetching category details. Example: 1
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response 200{
     *       "success": true,
     *       "status_code": 201,
     *       "message": "Category fetch successfully.",
     *       "data": {
     *           "id": 1,
     *           "name": "Iphone 14",
     *           "created_at": "22nd September, 2022"
     *       }
     *   }
     */
    public function show(Category $category)
    {
        try{
            $category = new CategoryResource($category);
            return $this->sendResponse( 'Category fetch successfully.', $category, 201);
        }catch(Exception $e){
            return $this->sendError($e->getMessage(), [], 500);  
        }
    }

     /**
     * @group Category
     * 
     * Update Category
     * @authenticated
     * @header Authorization Bearer token
     * 
     * @urlParam id required This id require for updating category details. Example: 1
     * @bodyParam  name string required. Example: iphone
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response 200{
     *       "success": true,
     *       "status_code": 201,
     *       "message": "Category updated successfully."
     *   }
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try{
            $category->update([
                "name" => $request->input('name')
            ]);
            return $this->sendResponse( 'Category updated successfully.', [], 201);
        }catch(Exception $e){
            return $this->sendError($e->getMessage(), [], 500);  
        }
    }


    /**
     * @group Category
     * 
     * Delete Category
     * @authenticated
     * @header Authorization Bearer token
     * 
     * @urlParam id required This id require for fetching category details. Example: 1
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response 200{
     *       "success": true,
     *       "status_code": 200,
     *       "message": "Category deleted successfully."
     *   }
     */
    public function destroy(Category $category)
    {
        try{
            $category->delete();
            return $this->sendResponse( 'Category deleted successfully.', [], 200);
        }catch(Exception $e){
            return $this->sendError($e->getMessage(), [], 500);  
        }
    }
}
