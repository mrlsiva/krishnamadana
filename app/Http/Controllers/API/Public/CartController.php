<?php

namespace App\Http\Controllers\API\Public;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Cart;
use Darryldecode\Cart\Cart as CartCart;
use App\Models\Product;
use App\Models\Category;
use App\Models\Variation;

class CartController extends Controller
{  
	public $successStatus = 200;
	public $errorStatus = 400;

	public Product $product;
    public $variations;
    public $selected_item;
    public $option_ids;
    public $selected_variation;
	
	/* 
	* Add product to the cart
	* @param $request - product slug
	*/
	public function add_to_cart(string $slug) 
    {
		try {
			
			$product = Product::with('media', 'items', 'items.configurations', 'items.configurations.option', 'items.configurations.variation')->where('slug', $slug)->first();					
			
			$option_id = array();
			if ($product) {
				$this->product = $product;
				$this->selected_item = $this->product->items->first();
				$this->option_ids = $this->selected_item->configurations->pluck('variation_option_id');
				foreach ($this->product->items as $index => $item) {
					foreach ($item->configurations as $configuration) {
						array_push($option_id, $configuration->variation_option_id);
					}
				}
				$this->variations = Variation::whereHas('options', fn ($query) => $query->whereIn('id', $option_id))
					->with(['options' => fn ($query) => $query->whereIn('id', $option_id)])
					->get();
					
				\Cart::add(array(
					'id' => $this->product->id,
					'name' => $this->product->name,
					'price' => $this->selected_item->amount,
					'quantity' => 1,
					'attributes' => array(
						'selected_variant' => [
							'id' => $this->selected_item->id,
							'amount' => $this->selected_item->amount,
						],
						'display_name' => $this->selected_item->display_name,
					),
					//'associatedModel' => $this->product
				));			
			
				/* $selected = Cart::getContent();
			echo "<pre>";
			print_r($selected); //return; */
				$message =  'Product added to cart successfully!';
				return response()->json(['success'=> true, 'message' => $message], $this->successStatus);  
			}else{
				$message =  'Product not exists';
				return response()->json(['success'=> false, 'message' => $message], $this->successStatus);  
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
	
	
	public function remove_from_cart(string $id)
    {
        try {
			if( \Cart::remove($id) ){
				$message =  'Product removed from cart successfully!';
				return response()->json(['success'=> true, 'message' => $message], $this->successStatus);
			}else{
				$message =  'Error removing product from cart!';
				return response()->json(['success'=> false, 'message' => $message], $this->successStatus);
			}
			
		}
        catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        }catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } 
    }
	
	 public function reduce_quantity(string $id)
    {
        try {
			$selected = \Cart::get($id);
			if ($selected['quantity'] == 1) {
				$this->remove_item($id);
			} else {
				\Cart::update($id, array(
					'quantity' => -1,
				));
			}
			$message =  'Cart quantity updated successfully!';
			return response()->json(['success'=> true, 'message' => $message], $this->successStatus);
		}
		catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        }catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } 
          
    }

    public function increase_quantity(int $id)
    {
        try {		
			
			/* $selected = Cart::getContent();
			echo "<pre>";
			print_r($selected); //return; */
			
			$selected = \Cart::get($id);	
			
			
			if ($selected['quantity'] > 9) {
				return;
			}
			\Cart::update($id, array(
				'quantity' => 1,
			));
			$message =  'Cart quantity updated successfully!';
			return response()->json(['success'=> true, 'message' => $message], $this->successStatus);
		}
		catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        }catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } 
    }
   
}
