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

class CategoriesController extends Controller
{  
	public $successStatus = 200;
	public $errorStatus = 400;
	

	/* 
	* Get all Categories list
	* @param - $slug - product slug name
	*/
	public function collections(string $slug) 
    {
		try {			
			
			if($slug != NULL || $slug != ''){           
                $category = Category::where('slug', $slug)->first();	
				
				if ($category) {
					 $categories = Product::published()->where('category_id', $category->id)->with('media')->get();
					 return response()->json(['success'=> true, 'data' => $categories], $this->successStatus);  
				  } else {
					 return response()->json(['success'=> false, 'data' => 'Category Not Exists'], $this->successStatus);  
				  }
	
				
            } else{
				$responseMsg['message'] = 'Invalid Category Slug';
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
