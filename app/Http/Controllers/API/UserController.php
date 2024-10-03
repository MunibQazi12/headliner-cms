<?php

namespace App\Http\Controllers\API;

use App\Helpers\ImageHelper;
use App\Models\Address;
use App\Models\User;
use App\Models\UserAddress;
use App\Rules\{MatchOldPassword};
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Log, Auth, DB, Validator};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends BaseController
{
    /**
     * @OA\Get(
     * path="/api/my-profile",
     * operationId="User Details",
     * tags={"User Management"},
     * summary="User Details Fetch",
     *  security={{"sanctum":{}}},
     * description="Get User Details ",
     *      @OA\Response(
     *          response=201,
     *          description="User retrieve Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function user()
    {
        try {
            $user = Auth::user();
            if (!is_null($user)) {
                return $this->sendResponse($user, 'User retrieved successfully.');
            } else {
                return $this->sendError("Whoops! no user found.", [], 404);
            }
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString() . "\n" . $th->getFile() . "\n" . $th->getLine());
            return $this->sendError('Server Error!', [], 500);
        }
    }
    /**
     * @OA\Post(
     * path="/api/personal-details-update",
     * operationId="Personal Details Update",
     * tags={"User Management"},
     * summary="Personal Details Update",
     * description=" Personal Details Update Here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"full_name","email","phone","company"},
     *               @OA\Property(property="full_name", type="String", example=""),
     *               @OA\Property(property="email", type="String", example=""),
     *               @OA\Property(property="phone", type="String", example=""),
     *               @OA\Property(property="company", type="String", example=""),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Personal Details update Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function personalUpdate(Request $request)
    {
        $inputs = $request->all();
        $validator  =   Validator::make($inputs, [
            'full_name'  =>  ['required', 'max:255'],
            'email' => ['required', 'email', 'regex:/(.+)@(.+)\.(.+)/i', 'max:255', Rule::unique('users', 'email')->ignore(Auth::id())],
            'phone' => ['required', Rule::unique('users', 'phone')->ignore(Auth::id()), 'digits:10', 'numeric'],
            'company' => ['required', 'max:255'],
            'profile_image' => $request->hasFile('profile_image') ? 'mimes:jpeg,png,jpg|max:2048' : '',
        ]);

        if ($validator->fails()) {
            return response()->json(["success" => false, "code" => 550, "message" => $validator->errors()->first()]);
        }
       
        try {
            $user = User::find(Auth::id());
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                
                $path = 'profile_photo';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                unset($inputs['profile_image']);
                $user->profile_photo_path = $final_image_url;
                $user->save();
              
              
            }
            $splitName = explode(' ', $inputs['full_name'], 2);
            $inputs['first_name'] = $splitName[0];
            $inputs['last_name'] = !empty($splitName[1]) ? $splitName[1] : '';

            unset($inputs['full_name']);
          
            $user->fill($inputs)->save();
            if ($user) {
                return $this->sendResponse($user, 'User update successfully.');
            } else {
                return $this->sendError('No profile found.', [], 201);
            }
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString() . "\n" . $th->getFile() . "\n" . $th->getLine());
            return $this->sendError('Server Error!', [], 500);
        }
    }
    /**
     * @OA\Post(
     * path="/api/update-password",
     * operationId="Update update password",
     * tags={"User Management"},
     * summary="Update update password",
     *   security={{"sanctum":{}}},
     * description="Update password here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *                required={"old_password","password","confirm_password"},
     *               @OA\Property(property="old_password", type="password", example=""),
     *               @OA\Property(property="password", type="password", example=""),
     *               @OA\Property(property="confirm_password", type="password", example=""),
     * 
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Password has been updated",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "old_password"  => ['required'],
            'password'  =>  ['required', Password::min(8)->max(25)],
            'confirm_password' => ['required_with:password', 'same:password'],
        ]);

        if ($validator->fails()) {
            return response()->json(["success" => false, "code" => 550, "message" => $validator->errors()->first()]);
        }

        try {
            $user = Auth::user();

            // The passwords matches
    
            if (!Hash::check($request->old_password, $user->password)) {
                return  $this->sendResponse(['error'=> "Current Password is Invalid"] , 200);
            }
    
    // Current password and new password same
            if ($request->current_password == $request->password)
            {
                return  $this->sendResponse(["error"=> "New Password cannot be same as your current password."] , 200);
            }
    
            $user->password = $request->password;
            $user->save();
            if (!is_null($user)) {
                return $this->sendResponse([], 'Update Password successfully.');
            } else {
                return $this->sendError([], 'Password updated fail.', 404);
            }
        } catch (\Throwable $th) {
            Log::error(" :: PROFILE UPDATE EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            return $this->sendError([], 'Server Error!', 500);
        }
    }
    /**
     * @OA\Post(
     * path="/api/add-address/{address_id?}",
     * operationId="saved user address here",
     * tags={"User Management"},
     * summary="saved user address here",
     * description="saved user address here here",
     *  @OA\Parameter(
     *          name="address_id",
     *          description="address_id",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"country_code","address_line_1","pin_code","country","city","is_default"},
     *               @OA\Property(property="country_code", type="String", example=""),
     *               @OA\Property(property="address_line_1", type="String", example=""),
     *               @OA\Property(property="address_line_2", type="String", example=""),
     *               @OA\Property(property="pin_code", type="String", example=""),
     *               @OA\Property(property="country", type="String", example=""),
     *               @OA\Property(property="city", type="String", example=""),
     *               @OA\Property(property="is_default", type="integer", example=""),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Address saved Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function addAddress(Request $request, $address_id = NULL)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'country_code' => 'required',
            'address_line_1' => 'required|max:255',
            'address_line_2' => 'nullable|max:255',
            'pin_code' => 'required|max:255',
            'country' => 'required|max:255',
            'city' => 'required|max:255',
            'is_default' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(["success" => false, "code" => 550, "message" => $validator->errors()->first()]);
        }
        DB::beginTransaction();
        try {
            $inputs['user_id'] = Auth::id();
            if ($request->has('is_default') && $request->input('is_default') == true) {
                UserAddress::where('user_id', Auth::id())->update(['is_default' => false]);
            }

            $address = UserAddress::updateOrCreate(['id' =>  $address_id], $inputs);

            DB::commit();
            if (!is_null($address)) {
                return $this->sendResponse($address, 'Address ' . ($address_id !== NULL ? 'updated' : 'created') . ' successfully.');
            } else {
                return $this->sendError('Address created failed!', [], 400);
            }
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString() . "\n" . $th->getFile() . "\n" . $th->getLine());
            return $this->sendError('Server Error!', [], 500);
        }
    }
    /**
     * @OA\Post(
     * path="/api/get-address",
     * operationId="Get address list",
     * tags={"User Management"},
     * summary="Get address list",
     * description="Get address list",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"page","per_page"},
     *               @OA\Property(property="page", type="numeric", example=""),
     *               @OA\Property(property="per_page", type="numeric", example=""),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Get address list Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getAddress(Request $request)
    {
        $validator  =   Validator::make($request->all(), [
            'page' => 'required|numeric|min:1',
            'per_page' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(["success" => false, "code" => 550, "message" => $validator->errors()->first()]);
        }
        $userAddress = UserAddress::whereUserId(Auth::id())->latest()->paginate($request->per_page);
        if ($userAddress->isNotEmpty()) {
            return $this->sendResponse($userAddress, 'User addresses retrieved successfully.');
        } else {
            return $this->sendError('No address found.', [], 404);
        }
    }
    /**
     * @OA\Get(
     * path="/api/delete-address/{address_id}",
     * operationId="User address deleted",
     * tags={"User Management"},
     * summary="User address deleted",
     * description="Get User address deleted ",
     *  @OA\Parameter(
     *          name="address_id",
     *          description="address_id",
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
    public function deleteAddress($address_id)
    {
        try {
            $userAddress = Address::whereUserId(Auth::id())->findOrFail($address_id);
            $userAddress->delete();

            return $this->sendResponse([], 'User address deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Address not found.", [], 404);
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString() . "\n" . $th->getFile() . "\n" . $th->getLine());
            return $this->sendError('Server Error!', [], 500);
        }
    }
}
