<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\User;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;
use Image;

class UserController extends Controller
{

    public function register(Request $request)
    {
        try {
            $request->validate([
                'email' => 'users.unique:users,email',
                'user.name'=>'required',
                'user.encrypted_password'=>'required',
                'user.phone'=>'required',
                'user.address'=>'required',
                'user.city'=>'required',
                'user.country'=>'required',
                'user.postcode'=>'required',
            ]);

            $user=new User();
            $user->username=$request['user']['username'];
            $user->name=$request['user']['name'];
            $user->email=$request['user']['email'];;
            $user->encrypted_password=Hash::make($request['user']['encrypted_password']);
            $user->phone=$request['user']['phone'];
            $user->address=$request['user']['address'];
            $user->city=$request['user']['city'];
            $user->country=$request['user']['country'];
            $user->postcode=$request['user']['postcode'];
            $user->save();

            $date = new \DateTime();
            $now = $date->getTimestamp();
            $payload = array(
                "id" => $user->id,
                "role_id" => Crypt::encryptString($user->id),
                "iat" => $now,
                "iss" => URL::to(''),
                "aud" => URL::to(''),
                "exp" => $now + (360 * 24 * 60 * 60)
            );

            $jwt = JWT::encode($payload, env("APP_KEY"));

            return response()->json(array(
                "email" => $user->email,
                "token" => $jwt,
                "username" => $user->username
            ));
            return response()->json(array(
                "code" => 200,
                "message" => "SUCCESS"
            ), ResponseStatus::HTTP_OK);
        } catch (ValidationException $e){
            foreach($e->errors() as $key => $value){
                return response()->json(array(
                    "code" => ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
                    "message" => $value[0]
                ), ResponseStatus::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (\Exception $e){
            return response()->json(array(
                "code" => 500,
                "message" => $e->getMessage()
            ), ResponseStatus::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request){
        $email = $request->email;
        $password = $request->password;

        $user = User::where("email", $email)->first();

        if (!empty($user)){
            if (password_verify($password, $user->encrypted_password)) {
                $date = new \DateTime();
                $now = $date->getTimestamp();
                $payload = array(
                    "id" => $user->id,
                    "role_id" => Crypt::encryptString($user->id),
                    "iat" => $now,
                    "iss" => URL::to(''),
                    "aud" => URL::to(''),
                    "exp" => $now + (360 * 24 * 60 * 60)
                );

                $jwt = JWT::encode($payload, env("APP_KEY"));

                return response()->json(array(
                    "email" => $user->email,
                    "token" => $jwt,
                    "username" => $user->username
                ));
            } else {
                return response()->json(array(
                    "code" => 401,
                    "message" => "UNAUTHENTICATION"
                ), ResponseStatus::HTTP_UNAUTHORIZED);
            }
        } else {
            return response()->json(array(
                "code" => 404,
                "message" => "NOT FOUND"
            ), ResponseStatus::HTTP_NOT_FOUND);
        }
    }

    public function index()
    {
        try {
            $users=User::all();
            return response()->json(array(
                "users" => $users,
            ), ResponseStatus::HTTP_OK);
        } catch (ModelNotFoundException $e){
            return response()->json(array(
                "code" => 404,
                "message" => "NOT FOUND"
            ), ResponseStatus::HTTP_NOT_FOUND);
        } catch (\Exception $e){
            return response()->json(array(
                "code" => 500,
                "message" => $e->getMessage()
            ), ResponseStatus::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
