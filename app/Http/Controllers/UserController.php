<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{


    public function register(Request $request)
    {
        $role = [
            'name'     => 'required|min:3',
            'email'    => 'required|min:3',
            'password' => 'required|confirmed|min:8',
        ];

        $validateData = Validator::make($request->all(),$role);

        if($validateData->fails()){

            return response()->json([
                'message' => 'Invalid data send',
                'Error' => $validateData->errors(),
            ], 400);

        }

        try {
            
            $data = array(
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
            );


            $run = User::create($data);

            
            if($run){
                return response()->json([
                    'code' => 200,
                    'message' => 'User Added Successfully..!'
                ]);
            }
            
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }



    public function login(Request $request){
        

        $rule = array(
            'email'    => 'email|required',
            'password' => 'required',
        );
    
        $validateData = Validator::make($request->all(),$rule);

        if($validateData->fails()){
            return response()->json([
                'message' => 'Invalid data send',
                'Error' => $validateData->errors(),
            ], 400);

        }
        
        try {
               if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                         $user    = Auth::user();
                $success['token'] = $user->createToken('innoscriptia.com')->plainTextToken;
                $success['name']  = $user->name;
                $success['id']    = $user->id;

                return response()->json([
                    'code'    => 200,
                    'message' => 'User login successfully.',
                    'data'    => $success
                ]);

            }else{ 
                return response()->json([
                    'code'    => 403,
                    'message' => 'Unauthorized Request',
                ]);
            } 
            
        } catch (\Exception $e) {
            return response()->json([
                'code' => 0,
                'error' => $e->getMessage(),
            ]);
        }
       
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
