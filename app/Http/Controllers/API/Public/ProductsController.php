<?php

namespace App\Http\Controllers\API\Public;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Config;
use DB;

use App\Models\Product;
use App\Models\Category;

class ProductsController extends Controller
{  
	public $successStatus = 200;
	public $errorStatus = 400;


	/* 
	* Get all products list
	* @param $request - post fields
	*/
	public function getAllProducts(Request $request) 
    {
		try {
			/* $validator = Validator::make($request->all(), [ 
                'sortBy' => 'required',
                'perPage' => 'required',
            ]); */
			
			$sortBy = 'latest';
			$perPage = 12;
			
			$input = $request->all();
			
			if ($request->has('sortBy')) {
				$sortBy = $input['sortBy'];
			}
			if ($request->has('perPage')) {
				$perPage = $input['perPage'];
			}		
		
			
			if ($sortBy == 'featured') {
				$products = Product::where('featured', true)->paginate($perPage);
			} else if ($sortBy == 'a-z') {
				$products = Product::orderBy('name', 'asc')->paginate($perPage);
			} else if ($sortBy == 'z-a') {
				$products = Product::orderBy('name', 'desc')->paginate($perPage);        
			} else if ($sortBy == 'latest') {
				$products = Product::latest()->paginate($perPage);
			} else if ($sortBy == 'oldest') {
				$products = Product::oldest()->paginate($perPage);
			}else if ($sortBy == 'low') {
				$products = Product::orderBy('display_price', 'asc')->paginate($perPage);
			} else if ($sortBy == 'heigh') {
				$products = Product::orderBy('display_price', 'desc')->paginate($perPage);
			} else {
				$products = Product::paginate($perPage);
			}

			return response()->json(['success'=> true, 'data' => $products], $this->successStatus);  

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
	
	/* 
	* Get product deatils by product slug
	* @param - $slug - product slug name
	*/
	public function productDetails(string $slug) 
    {
		try {	
			
			if($slug != NULL || $slug != ''){           
                $product = Product::with('media', 'items', 'items.configurations', 'items.configurations.option', 'items.configurations.variation')->where('slug', $slug)->first();
				
				return response()->json(['success'=> true, 'data' => $product], $this->successStatus);  
				
            } else{
				$responseMsg['message'] = 'Invalid Product Slug';
				return response()->json(['success'=> false, 'data' => $responseMsg], $this->successStatus);  
			}			

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
