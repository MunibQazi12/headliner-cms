<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductAttribut;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CartController extends BaseController
{
    /**
     * @OA\Get(
     * path="/api/get-dry-ice-pallet/{id}",
     * operationId="dry-ice-pallet",
     * tags={"Cart Management"},
     * summary="Get add to cart page",
     * description="Dry Ice Pallet page ",
     *  @OA\Parameter(
     *          name="id",
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Address Deleted Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function DryicePallet($id)
    {
        try {
            $product = Product::with('product_attr')->where('status', 1)->findOrFail($id);

            return $this->sendResponse($product, 'Data Retrived Successfully', 201);
        }catch (ModelNotFoundException $e) {
            return $this->sendResponse([],"No dry ice found.", [], 404);
        }  catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            return $this->sendError([], 'something went wrong', 500);
            abort(500);
        }
    }


    public function AddToCart(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'product_attr_id' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'shipping_charge' => 'nullable'
        ]);

        if ($validate->fails()) {
            return response()->json(["success" => false, "code" => 550, "message" => $validate->errors()->first()]);
        }
        try {

            $exists = Cart::where('product_attr_id', $request->product_attr_id)->where('product_id', $request->product_id)->where('user_id', Auth::id())->exists();
            $Originalprice = ProductAttribut::where('id', $request->product_attr_id)->where('product_id', $request->product_id)->get('price')->toArray();
            if (!$exists) {
                $cart = new Cart;
                $cart->user_id = Auth::id();
                $cart->product_id = $request->product_id;
                $cart->product_attr_id = $request->product_attr_id;
                $cart->quantity = $request->quantity;
                $cart->price = $request->quantity * $Originalprice[0]['price'];
                if ($request->quantity * $Originalprice[0]['price'] > 50) {

                    $cart->shipping_charge = 50;
                }
            } else {
                $cart = Cart::where('product_attr_id', $request->product_attr_id)->where('product_id', $request->product_id)->where('user_id', Auth::id())->first();
                $quantity = $cart->quantity;
                $price = $cart->price;
                $cart->quantity = $quantity + $request->quantity;
                $cart->price = $cart->quantity * $price;
                if ($quantity * $Originalprice[0]['price'] < 50) {

                    $cart->shipping_charge = 50;
                }
                $cart->shipping_charge = 0;
            }
            $cart->save();

            return $this->sendResponse($cart, 'Successfully added to cart', 201);
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            return $this->sendError([], 'something went wrong', 500);
            abort(500);
        }
    }

    /**
     * @OA\Post(
     * path="/api/view-cart",
     * operationId="view-cart",
     * tags={"Cart Management"},
     * summary="view-cart",
     * description="view-cart",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={},
     *               @OA\Property(property="per_page", type="numeric", example=""),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Data Fetched",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function viewCart(Request $request)
    {
        $perPage = $request->perPage ?? 5;

        $cart = Cart::with(
            'user:id,email,gender,phone,company,active,address',
            'product:id,name,description,available_stock,status',
            'product_attribute:id,size,details,price'
        )->where('user_id', Auth::id())->paginate($perPage);
        return response()->json($cart);
    }
}
