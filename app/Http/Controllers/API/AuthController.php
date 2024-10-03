<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Mail\ForgetPassword;
use App\Models\AppleId;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Log, Mail, Validator};
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Stripe\Customer;
use Stripe\Stripe;

class AuthController extends BaseController
{
    /**
     * @OA\Post(
     * path="/api/register",
     * operationId="Register",
     * tags={"Auth Management"},
     * summary="User Register",
     * description="User Register here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"full_name","email", "phone","company", "password","password_confirmation"},
     *               @OA\Property(property="full_name", type="String", example=""),
     *               @OA\Property(property="email", type="email", example=""),
     *               @OA\Property(property="phone", type="integer", example=""),
     *               @OA\Property(property="company", type="string", example=""),
     *               @OA\Property(property="password", type="password", example=""),
     *               @OA\Property(property="password_confirmation", type="password", example=""),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Register Successfully.",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function register(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $inputs = $request->all();
        $validator  =   Validator::make($inputs, [
            'full_name'  =>  ['required', 'max:255'],
            'email' => ['required', 'email', 'regex:/(.+)@(.+)\.(.+)/i', 'max:255', Rule::unique('users', 'email')],
            'phone' => ['required', Rule::unique('users', 'phone'), 'digits:10', 'numeric'],
            'company' => ['required', 'max:255'],
            'password'  =>  ['required', Password::min(8)->max(25)],
            'password_confirmation' => ['required_with:password', 'same:password'],
        ]);

        if ($validator->fails()) {
            return response()->json(["success" => false, "code" => 550, "message" => $validator->errors()->first()]);
        }

        DB::beginTransaction();
        try {
            $splitName = explode(' ', $inputs['full_name'], 2);
            $inputs['first_name'] = $splitName[0];
            $inputs['last_name'] = !empty($splitName[1]) ? $splitName[1] : '';
            $inputs['active'] = 1;


            $customer = Customer::create([
                'email' => $request->email,
                'name' => $request->name,
            ]);

            $inputs['customer_id'] = $customer->id;
            unset($inputs['full_name']);
            unset($inputs['password_confirmation']);
            $user = User::create($inputs);
            $user->assignRole('USER');
            DB::commit();
            $get_user = User::find($user->id);
            if ($get_user) {
                return $this->sendResponse($get_user, 'Registration successfully done, please login your account.');
            } else {
                return $this->sendError('Registration failed!', [], 400);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString() . "\n" . $th->getFile() . "\n" . $th->getLine());
            return $this->sendError('Server Error!', [], 500);
        }
    }

    public function oneTapSignin(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $inputs = $request->all();
        $validator  =   Validator::make($inputs, [
            'first_name'  =>  ['required', 'max:255'],
            'last_name'  =>  ['required', 'max:255'],
            'email' => ['required', 'email', 'regex:/(.+)@(.+)\.(.+)/i', 'max:255'],

        ]);

        if ($validator->fails()) {
            return response()->json(["success" => false, "code" => 550, "message" => $validator->errors()->first()]);
        }
        $user = User::role('USER')->where('email', $request->email)->first();
        if($request->apple_user_id){
            $appleEmail = AppleId::where("user_id" , $request->apple_user_id)->first();
            if($appleEmail){
                $user = User::role('USER')->where('email',   $appleEmail->email)->first();
            } else if( $user ) {
                AppleId::create([
                    "user_id" => $request->apple_user_id,
                    "email" => $request->email,
                    "given_name" => $request->first_name . " " . $request->last_name
                ]);
            }
        }
        if ($user) {
            $token = $user->createToken('token')->plainTextToken;
            return $this->sendResponse(['user' => $user, 'token' => $token], 'Login successfully done.');
        } else {
            DB::beginTransaction();
            try {

                $inputs['active'] = 1;

                if($request->apple_user_id){
                    $appleEmail = AppleId::where("user_id" , $request->apple_user_id)->first();
                    if($appleEmail){
                        $request->email = $appleEmail->email;
                        $inputs['email'] = $appleEmail->email;
                        $splitName = explode(' ', $appleEmail->given_name, 2);
                        $request->first_name =  $splitName[0];
                        $inputs['first_name'] =  $splitName[0];
                        $request->last_name =  $splitName[1];
                        $inputs['last_name'] =  $splitName[1];
                        
                    } else {
                        AppleId::create([
                            "user_id" => $request->apple_user_id,
                            "email" => $request->email,
                            "given_name" => $request->first_name . " " . $request->last_name
                        ]);
                    }
                    unset($inputs['apple_user_id']);
                }
                $customer = Customer::create([
                    'email' => $request->email,
                    'name' => $request->first_name . ' ' . $request->last_name,
                ]);

                $inputs['customer_id'] = $customer->id;
                $inputs['password'] = bcrypt($request->email);
                $user = User::create($inputs);
               
                $user->assignRole('USER');
                DB::commit();
                $get_user = User::find($user->id);
                if ($get_user) {
                    $token = $user->createToken('token')->plainTextToken;
                    return $this->sendResponse(["user" => $get_user, "token" => $token], 'Registration successfully done, please login your account.');
                } else {
                    return $this->sendError('Registration failed!', [], 400);
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString() . "\n" . $th->getFile() . "\n" . $th->getLine());
                return $this->sendError('Server Error!', [], 500);
            }
        }
    }

    /**
     * @OA\Post(
     * path="/api/login",
     * operationId="authLogin",
     * tags={"Auth Management"},
     * summary="User Login (login with email)",
     * description="Login User Here (login with email)",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "password"},
     *               @OA\Property(property="email", type="email", example=""),
     *               @OA\Property(property="password", type="password", example=""),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Login Successfully",
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

    public function login(Request $request)
    {
        $rules = [
            'email' =>  'required|max:255',
            'password'  =>  'required|min:8|max:25',
        ];

        $messages = [
            'max' => "You password must be within 8 to 25 character.",
            'min' => "You password must be within 8 to 25 character.",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(["success" => false, "code" => 550, "message" => $validator->errors()->first()]);
        }

        try {
            $user = User::role('USER')
                ->where("email", $request->email)
                ->first();

            if (!$user) {
                return $this->sendError('Email address or phone number not match our credential.', [], 550);
            }

            /** Does not login Inactive user */
            if ($user->active == 0) {
                return $this->sendError("Failed! Your account is not active or no longer available, Please contact admin.", [], 501);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $token = $user->createToken('token')->plainTextToken;
                return $this->sendResponse(['user' => $user, 'token' => $token], 'Login successfully done.');
            } else {
                return $this->sendError("Whoops! Credential mismatch/password mismatch.", [], 501);
            }
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString() . "\n" . $th->getFile() . "\n" . $th->getLine());
            return $this->sendError('Server Error!', [], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/api/forget-password-send-otp",
     * operationId="Send otp",
     * tags={"Auth Management"},
     * summary="Forget password send otp",
     * description="Forget password send otp Here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email"},
     *               @OA\Property(property="email", type="email", example=""),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="otp send Successfully",
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

    public function forgetPasswordSendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' =>  'required|email:rfc,dns|regex:/(.+)@(.+)\.(.+)/i|exists:users,email|max:255'
        ], ['exists' => 'This email address not exists.']);

        if ($validator->fails()) {
            return response()->json(["success" => false, "code" => 550, "message" => $validator->errors()->first()]);
        }
        try {
            $otp = rand(1111, 9999);
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $otp,
                'created_at' => Carbon::now()
            ]);

            $dataVal = [
                'email' => $request->email,
                'otp' => $otp,
                'text' => 'Here is your one time 4 digit OTP, do not share your OTP with others :-',
            ];
            
            Mail::to($request->email)->send(new ForgetPassword($dataVal));

            return $this->sendResponse(['email' => $request->email], 'Otp sent successfully to your register email address.');
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString() . "\n" . $th->getFile() . "\n" . $th->getLine());
            return $this->sendError('Server Error!', [], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/api/forget-password-verify-otp",
     * operationId="Verify otp",
     * tags={"Auth Management"},
     * summary="Forget password verify otp",
     * description="Forget password verify otp Here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email","otp"},
     *               @OA\Property(property="email", type="email", example=""),
     *               @OA\Property(property="otp", type="integer", example="", description="OTP will 60 second valid"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="verify otp Successfully",
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

    public function forgetPasswordVerifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'otp' =>  'required|exists:password_reset_tokens,token',
        ], ['otp.exists' => 'Wrong OTP']);

        if ($validator->fails()) {
            return response()->json(["success" => false, "code" => 550, "message" => $validator->errors()->first()]);
        }

        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return $this->sendError("Whoops! user not found", [], 404);
            }
            $tokenData = DB::table('password_reset_tokens')
                ->where(['token' => $request->otp, 'email' => $request->email])
                ->first();

            if (!$tokenData) {
                return $this->sendError("OTP mismatch", [], 404);
            }

            $createdAt = strtotime($tokenData->created_at);
            $currentTime = time();

            /** OTP will 60 second valid */
            if ($currentTime - $createdAt <= 60) {
                /** Update token and mark as verified */
                $tokenData = DB::table('password_reset_tokens')
                    ->where('token', $request->otp)
                    ->update(['is_verify' => 1]);

                $token = $user->createToken('token')->plainTextToken;
                return $this->sendResponse($token, "OTP validation successful. Please reset your password.");
            } else {
                /** Delete expired OTP */
                $tokenData = DB::table('password_reset_tokens')
                    ->where(['token' => $request->otp, 'email' => $request->email])
                    ->delete();
                return $this->sendError("OTP expired. Please click on resend", [], 404);
            }
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            return $this->sendError('Server Error!', [], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/api/change-password",
     * operationId="Change Password",
     * tags={"Auth Management"},
     * summary="Change Password",
     * description=" Change Password Here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email","password","confirm_password"},
     *               @OA\Property(property="email", type="email", example=""),
     *               @OA\Property(property="password", type="password", example=""),
     *               @OA\Property(property="confirm_password", type="password", example=""),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Change Password Successfully",
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

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password'  =>  ['required', Password::min(8)->max(25)],
            'confirm_password' => 'required_with:password|same:password',
        ], [
            'password.required' => 'The new password fields is required',
            'password.max' => 'Password must be within 8 to 25 digit !',
            'confirm_password.required' => 'The re-entered password fields is required',
            'confirm_password.same' => 'The new password & re-entered password must match',
        ]);



        if ($validator->fails()) {
            return response()->json(["success" => false, "code" => 550, "message" => $validator->errors()->first()]);
        }
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return $this->sendError("Whoops! user not found.", [], 404);
            }

            $tokenData = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->first();

            if (!empty($tokenData) && !is_null($user)) {
                if ($tokenData->is_verify == 1) {
                    DB::table('password_reset_tokens')
                        ->where('email', $request->email)
                        ->delete();
                    $user->update(['password' => $request->password]);
                    return $this->sendResponse([], 'Password changed successfully.');
                } else {
                    return $this->sendError('Otp not verified.', [], 400);
                }
            } else {
                return $this->sendError('Invalid otp.', [], 400);
            }
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString() . "\n" . $th->getFile() . "\n" . $th->getLine());
            return $this->sendError('Server Error!', [], 500);
        }
    }
}
