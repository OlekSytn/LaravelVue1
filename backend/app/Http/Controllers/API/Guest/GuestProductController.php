<?php

namespace App\Http\Controllers\API\Guest;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Exception;
use Illuminate\Support\Facades\Auth;
use File;

class GuestProductController extends BaseController
{
    /**
     * @group Guest
     * 
     * Product List
     * 
     * @response 200{
     *        "success": true,
     *        "status_code": 200,
     *        "message": "Product fetch successfully.",
     *        "data": [
     *            {
     *               "id": 16,
     *               "name": "Nokia 1200",
     *               "details": "Old Iphone",
     *               "price": "34.00",
     *               "image": "http://localhost/Learning/appnap-assignment/backend/public/storage/product-images/JDZ3ICe9dVBoYVtItuXa4xkLHnMRGb3MrBs1QAj8.png",
     *               "category": "Nokia",
     *               "category_id": 3,
     *               "user": "Rabiul Hasan",
     *               "created_at": "23rd September, 2022"
     *           }
     *       ]
     *   }
     */
    public function index()
    {
        try{
            $products =  ProductResource::collection(Product::all());
            return $this->sendResponse('Product fetch successfully.', $products);
        }catch(Exception $e){
            return $this->sendError($e->getMessage(), [], 500);  
        } 
    }


    /**
     * @group Guest
     * 
     * Product Details
     * 
     * @urlParam id required This id require for fetching product details. Example: 1
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response 200{
     *       "success": true,
     *       "status_code": 201,
     *       "message": "Product fetch successfully.",
     *       "data": {
     *           "id": 16,
     *           "name": "Nokia 1200",
     *           "details": "Old Iphone",
     *           "price": "34.00",
     *           "image": "http://localhost/Learning/appnap-assignment/backend/public/storage/product-images/JDZ3ICe9dVBoYVtItuXa4xkLHnMRGb3MrBs1QAj8.png",
     *           "category": "Nokia",
     *           "category_id": 3,
     *           "user": "Rabiul Hasan",
     *           "created_at": "23rd September, 2022"
     *       }
     *   }
     */
    public function details(Product $product)
    {
        try{
            $product = new ProductResource($product);
            return $this->sendResponse( 'Product fetch successfully.', $product, 201);
        }catch(Exception $e){
            return $this->sendError($e->getMessage(), [], 500);  
        }
    }


}
