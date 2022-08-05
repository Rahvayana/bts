<?php

namespace App\Http\Controllers;

use App\Models\Shopping;
use Illuminate\Http\Request;
use App\Mail\ForgotPassword;
use App\Models\User;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;
use Image;

class ShoppingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $shoppings=Shopping::all();
            return response()->json(array(
                "shoppings" => $shoppings,
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'shopping.name' => 'required',
                'shopping.createddate'=>'required',
            ]);

            $shopping=new Shopping();
            $shopping->name=$request['shopping']['name'];
            $shopping->createddate=$request['shopping']['createddate'];
            $shopping->save();

            return response()->json(array(
                "data" => $shopping,
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shopping  $shopping
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $shopping=Shopping::findOrFail($id);
            return response()->json(array(
                "shoppings" => $shopping,
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shopping  $shopping
     * @return \Illuminate\Http\Response
     */
    public function edit(Shopping $shopping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shopping  $shopping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'shopping.name' => 'required',
                'shopping.createddate'=>'required',
            ]);

            $shopping=new Shopping();
            $shopping=Shopping::findOrFail($id);
            $shopping->name=$request['shopping']['name'];
            $shopping->createddate=$request['shopping']['createddate'];
            $shopping->save();

            return response()->json(array(
                "data" => $shopping,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shopping  $shopping
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $shopping = Shopping::findOrFail($id);
            $shopping->delete();
            return response()->json(array(
                "code" => 200,
                "message" => "SUCCESS"
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
