<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;
use App\Models\ProductMeta;
use Validator;
use Livewire\WithPagination;

class AdminProductController extends Controller
{
    public $successStatus = 200;
	public $errorStatus = 400;

    use WithPagination;

    /* Get All Products  */
    public function index()
    {
        try {
            $products = Product::paginate(12);   
		    return response()->json(['success' => true, 'data' => $products], $this->successStatus); 
        }
        catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\PDOException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        }     
    }

    /* Add new Product  */
    public function createProduct(Request $request)
    {
        try {			
			$validator = Validator::make($request->all(), [ 
                'name' => 'required|min:3',
				'description' => 'required',
				'additional_info' => 'nullable',
				'category_id' => 'required',
                'display_price' => 'required',
				'status' => 'nullable',
				'visibility' => 'nullable',
				'meta_title' => 'nullable',
				'meta_keywords' => 'nullable',
				'meta_description' => 'nullable',
                'images' => 'nullable',
                'items' => 'required_if:product.status,Published',
            ]);
            if ($validator->fails()) {   
				$message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
			$input = $request->all(); 	

            /* Product Data */ 
            $product = new Product();
            $product->name = $input['name'];            
            $product->description = $input['description'];
            $product->additional_info = isset($input['additional_info']) ? $input['additional_info'] : null;
            $product->category_id = $input['category_id'];
            $product->display_price  = $input['display_price'];
            $product->status = 'Published';
            $product->visibility = 'Public';            
            $product->save();

            /* Product Meta Data */    
            $productmeta = new ProductMeta();
            $productmeta->product_id  = $product->id;
            $productmeta->title  = isset($input['meta_title']) ? $input['meta_title'] : null; 
            $productmeta->keywords  = isset($input['meta_keywords']) ? $input['meta_keywords'] : null;
            $productmeta->description  = isset($input['meta_description']) ? $input['meta_description'] : null;
            $productmeta->save(); 

            /* Product Images */ 
            if($request->file('images')) {
                $fileAdders = $product->addMultipleMediaFromRequest(['images'])
                        ->each(function ($fileAdder) {
                            $fileAdder->withResponsiveImages()->toMediaCollection('products');
                        });                     
            }

            $message = 'Product added successfully';;
            return response()->json(['success'=> true, 'message' => $message], $this->successStatus);
        }
        catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\PDOException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } 
    }

    /* Update Product  */
    public function editProduct(Request $request, $id)
    {
        try {			
			$validator = Validator::make($request->all(), [ 
                'name' => 'required|min:3',
				'description' => 'required',
				'additional_info' => 'nullable',
				'category_id' => 'required',
                'display_price' => 'required',
				'status' => 'nullable',
				'visibility' => 'nullable',
				'meta_title' => 'nullable',
				'meta_keywords' => 'nullable',
				'meta_description' => 'nullable',
                'images' => 'nullable',
                'items' => 'required_if:product.status,Published',
            ]);
            if ($validator->fails()) {   
				$message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
			$input = $request->all(); 	

            /* Product Data */            
            $product = Product::findOrFail($id);
            $product->name = $input['name'];            
            $product->description = $input['description'];
            $product->additional_info = isset($input['additional_info']) ? $input['additional_info'] : null;
            $product->category_id = $input['category_id'];
            $product->display_price  = $input['display_price'];
            $product->status = 'Published';
            $product->visibility = 'Public';            
            $product->save();

            /* Product Meta Data */    
            if( isset($input['meta_title']) || !empty($input['meta_title']) ) {
                $productmeta = ProductMeta::updateOrCreate(
                    ['product_id' => $id],
                    [
                        'title' => $input['meta_title'],
                        'keywords' => isset($input['meta_keywords']) ? $input['meta_keywords'] : null,
                        'description' => isset($input['meta_description']) ? $input['meta_description'] : null,
                    ]
                );
            }                   

            /* Product Images */ 
            if($request->file('images')) {
                $fileAdders = $product->addMultipleMediaFromRequest(['images'])
                        ->each(function ($fileAdder) {
                            $fileAdder->withResponsiveImages()->toMediaCollection('products');
                        });                     
            }

            $message = 'Product updated successfully';;
            return response()->json(['success'=> true, 'message' => $message], $this->successStatus);
        }
        catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\PDOException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } 
    }

    /* Delete Product  */
    public function deleteProduct(Request $request, $id)
    {
        try {	
            $product = Product::findOrFail($id);
            $product->delete();
            $productmata = ProductMeta::where('product_id' , $id)->delete();

            $message = 'Product deleted successfully';;
            return response()->json(['success'=> true, 'message' => $message], $this->successStatus);
        }
        catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\PDOException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } 
    }
}