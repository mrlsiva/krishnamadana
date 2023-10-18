<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductMeta;
use Validator;
use Livewire\WithPagination;

class AdminCategoryController extends Controller
{
    public $successStatus = 200;
	public $errorStatus = 400;

    use WithPagination;

    /* Get All Category  */
    public function categoriesIndex()
    {
        try {
            $category = Category::paginate(12);   
		    return response()->json(['success' => true, 'data' => $category], $this->successStatus); 
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

    /* Add new Category  */
    public function createCategory(Request $request)
    {
        try {			
			$validator = Validator::make($request->all(), [ 
                'name' => 'required|min:3',
                'order' => 'required|numeric',
                'image' => 'required|file|mimes:jpg,png,webp'                
            ]);
            if ($validator->fails()) {   
				$message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
			$input = $request->all(); 	

            /* Category Data */ 
            $category = new Category();
            $category->name = $input['name'];            
            $category->order = $input['order'];
            $category->save();
        
            /* Product Images */ 
            if($request->file('image')) {
                $fileAdders = $category->addMultipleMediaFromRequest(['image'])
                        ->each(function ($fileAdder) {
                            $fileAdder->withResponsiveImages()->toMediaCollection('categories');
                        });                     
            }

            $message = 'Category added successfully';;
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

    /* Update Category  */
    public function editCategory(Request $request, $id)
    {
        try {			
			$validator = Validator::make($request->all(), [ 
                'name' => 'required|min:3',
                'order' => 'required|numeric',
                'image' => 'nullable|file|mimes:jpg,png,webp'
            ]);
            if ($validator->fails()) {   
				$message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
			$input = $request->all(); 	

            /* Category Data */            
            $category = Category::findOrFail($id);
            $category->name = $input['name'];            
            $category->order = $input['order'];                    
            $category->save();                         

            /* Category Images */ 
            if($request->file('image')) {
                $fileAdders = $category->addMultipleMediaFromRequest(['image'])
                        ->each(function ($fileAdder) {
                            $fileAdder->withResponsiveImages()->toMediaCollection('categories');
                        });                     
            }

            $message = 'Category updated successfully';;
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

    /* Delete Category  */
    public function deleteCategory(Request $request, $id)
    {
        try {	
            $category = Category::findOrFail($id);
            $category->delete();
            
            $message = 'Category deleted successfully';;
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