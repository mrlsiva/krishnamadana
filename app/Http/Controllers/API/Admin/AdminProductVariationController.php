<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;
use App\Models\Variation;
use App\Models\VariationOption;
use Validator;
use DB;
use Livewire\WithPagination;

class AdminProductVariationController extends Controller
{
    public $successStatus = 200;
	public $errorStatus = 400;

    use WithPagination;

    /* Get All Product Variations */
    public function index()
    {
        try {
            $variation = Variation::paginate(12); 
		    return response()->json(['success' => true, 'data' => $variation], $this->successStatus); 

          /*  $variation = DB::table('variations as v')
            ->select(
                'v.id',
                'v.name',  
                'v.category_id',               
                's.shiftId as shid',
                's.shiftName', 
            )
            ->leftJoin('attendance as a', 'a.userId', '=', 'u.userId') ::paginate(12); */   
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

    /* Add new Product Variation */
    public function createVariation(Request $request)
    {
        try {			
            $validator = Validator::make($request->all(), [ 
                'name' => 'required|min:3',
                'category_id' => 'nullable',                 
            ]);
            if ($validator->fails()) {   
                $message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
            $input = $request->all(); 	

            /* Variation Data */ 
            $variation = new Variation();
            $variation->name = $input['name']; 
            $variation->category_id = isset($input['category_id']) ? $input['category_id'] : NULL;                    
            $variation->save();           

            $message = 'Variation added successfully';;
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

    /* Update Product Variation */
    public function editVariation(Request $request, $id)
    {
        try {			
            $validator = Validator::make($request->all(), [ 
                'name' => 'required|min:3',
                'category_id' => 'nullable',                 
            ]);
            if ($validator->fails()) {   
                $message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
            $input = $request->all(); 	

            /* Variation Data */ 
            $variation = Variation::findOrFail($id);
            $variation->name = $input['name']; 
            $variation->category_id = isset($input['category_id']) ? $input['category_id'] : NULL;                    
            $variation->save();           

            $message = 'Variation updated successfully';;
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

    /* Delete Variation  */
    public function deleteVariation(Request $request, $id)
    {
        try {	
            $variation = Variation::findOrFail($id);
            $variation->delete();

            $message = 'Variation deleted successfully';;
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


    /* ******************************* Variation Options ********************************* */
    /* Get All Product Variations & Options */
    public function indexVariationOption()
    {
        try {
            $data['variation'] = Variation::all();
            $data['variation_option'] = VariationOption::all();

		    return response()->json(['success' => true, 'data' => $data], $this->successStatus);               
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

    /* Add new Product Variation Option */
    public function createVariationOption(Request $request)
    {
        try {			
            $validator = Validator::make($request->all(), [ 
                'variation_id' => 'required',
                'value' => 'required',                 
            ]);
            if ($validator->fails()) {   
                $message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
            $input = $request->all(); 	

            /* Variation Data */ 
            $variationoption = new VariationOption();
            $variationoption->variation_id = $input['variation_id']; 
            $variationoption->value = $input['value'];                    
            $variationoption->save();           

            $message = 'Variation Option added successfully';;
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

    /* Update Product Variation Option */
    public function editVariationOption(Request $request, $id)
    {
        try {			
            $validator = Validator::make($request->all(), [ 
                'variation_id' => 'required',
                'value' => 'required',                  
            ]);
            if ($validator->fails()) {   
                $message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
            $input = $request->all(); 	

            /* Variation Option Data */ 
            $variationoption = VariationOption::findOrFail($id);
            $variationoption->variation_id = $input['variation_id']; 
            $variationoption->value = $input['value'];                     
            $variationoption->save();           

            $message = 'Variation Option updated successfully';;
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

    /* Delete Variation Option */
    public function deleteVariationOption(Request $request, $id)
    {
        try {	
            $variationoption = VariationOption::findOrFail($id);
            $variationoption->delete();

            $message = 'Variation Option deleted successfully';;
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
