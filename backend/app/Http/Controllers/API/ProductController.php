<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Exception;
use Illuminate\Support\Facades\Auth;
use File;

class ProductController extends BaseController
{
    /**
     * @group Product
     * 
     * Product List
     * @authenticated
     * @header Authorization Bearer token
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
            $products =  ProductResource::collection(Product::where('user_id', Auth::user()->id)->get());
            return $this->sendResponse('Product fetch successfully.', $products);
        }catch(Exception $e){
            return $this->sendError($e->getMessage(), [], 500);  
        } 
    }

    
    /**
     * @group Product
     * 
     * Add Product
     * @authenticated
     * @header Authorization Bearer token
     * 
     * @bodyParam  name string required. Example: Iphone-13
     * @bodyParam  details text required. Example: old-iphone
     * @bodyParam  price number required. Example: 999.00
     * @bodyParam  category_id integer required. Example: 1
     * @bodyParam  image file required
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response 200{
     *       "success": true,
     *       "status_code": 201,
     *       "message": "Product created successfully."
     *   }
     */
    public function store(CreateProductRequest $request)
    {
        $uploadFolder = 'product-images';
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        
        try{
            Product::create([
                "category_id" => $request->input('category_id'),
                "user_id"     => Auth::user()->id,
                "name"        => $request->input('name'),
                "details"     => $request->input('details'),
                "price"       => $request->input('price'),
                "image"       => "public/storage/{$image_uploaded_path}"
            ]);
            return $this->sendResponse( 'Product created successfully.', [], 201);
        }catch(Exception $e){
            return $this->sendError($e->getMessage(), [], 500);  
        }


    }

    /**
     * @group Product
     * 
     * Show Single Product
     * @authenticated
     * @header Authorization Bearer token
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
    public function show(Product $product)
    {
        try{
            $product = new ProductResource($product);
            return $this->sendResponse( 'Product fetch successfully.', $product, 201);
        }catch(Exception $e){
            return $this->sendError($e->getMessage(), [], 500);  
        }
    }


    public function update(Request $request, Product $product){}


    /**
     * @group Product
     * 
     * Update Product
     * @authenticated
     * @header Authorization Bearer token
     * 
     * @urlParam id required This id require for updating product details. Example: 1
     * @bodyParam  name string required. Example: Iphone-13
     * @bodyParam  details text required. Example: old-iphone
     * @bodyParam  price number required. Example: 999.00
     * @bodyParam  category_id integer required. Example: 1
     * @bodyParam  image file
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response 200{
     *       "success": true,
     *       "status_code": 201,
     *       "message": "Category updated successfully."
     *   }
     */
    public function productUpdate(UpdateProductRequest $request, $id){
         
        $product = Product::find($id);

        if($product->user_id != Auth::user()->id){ // check product owner ship
            return $this->sendError("Only owner can delete her product", [], 401);  
        }
		
        if($request->has('image') && !empty($request->file('image')) ){
            $uploadFolder        = 'product-images';
            $image               = $request->file('image');
            $image_uploaded_path = $image->store($uploadFolder, 'public');
            $image_path          = "public/storage/{$image_uploaded_path}";
			
			// remove old image from directory
			$old_image = $product->image;
			if(File::exists($old_image)){
                unlink($old_image);
            }
			
			
        }else{
            $image_path = $product->image; // old image path cannot be changed
        }
        
        try{
            Product::where('id', $id)->update([
                "category_id" => $request->input('category_id'),
                "user_id"     => Auth::user()->id,
                "name"        => $request->input('name'),
                "details"     => $request->input('details'),
                "price"       => $request->input('price'),
                "image"       => $image_path
            ]);
            return $this->sendResponse( 'Product updated successfully.', [], 201);
        }catch(Exception $e){
            return $this->sendError($e->getMessage(), [], 500);  
        }
        
    }

    /**
     * @group Product
     * 
     * Delete Product
     * @authenticated
     * @header Authorization Bearer token
     * 
     * @urlParam id required This id require for delete product details. Example: 1
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response 200{
     *       "success": true,
     *       "status_code": 200,
     *       "message": "Product deleted successfully."
     *   }
     */
    public function destroy(Product $product)
    {
        if($product->user_id != Auth::user()->id){ // check product owner ship
            return $this->sendError("Only owner can delete her product", [], 401);  
        }

        try{
            $product->delete();
            return $this->sendResponse( 'Product deleted successfully.', [], 200);
        }catch(Exception $e){
            return $this->sendError($e->getMessage(), [], 500);  
        }

    }
}
