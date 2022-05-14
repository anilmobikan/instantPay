<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Board;
use App\Models\Task;
use DB;

class UserController extends Controller
{
    public function index(){

        $users = User::with('board')->find(Auth::user()->id)->toArray();
        $user = User::find(Auth::user()->id)->toArray();
       // dd($users);
        //$board['tasks'] = [];
         foreach($users['board'] as $brd){
            $arr1 = $brd;
            $datatask = \App\Helpers\Helper::getTask($brd['id']);
            
           $arr[] =   array_merge($arr1,['tasks'=>$datatask]);
               //dd($brd,$board);
           
         }
      $data =   array_merge($user,['boards'=>$arr]);
         //dd($data,$arr);
       return response()
            ->json(['message' => 'User data','data'=>$data]);
      
        
    }
    public function update(Request $request,$id){

         $validator = Validator::make($request->all(),[
            'name' => 'string|max:255',
            'username' => 'string|max:255',
            'email' => 'string|email|max:255',
            'password' => 'string|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
         $user = User::findOrFail($id);
         $user['name'] = $request->name ? $request->name : $user->name;
         $user['username'] = $request->username ? $request->username : $user->username;
         $user['email'] = $request->email ? $request->email : $user->email;
         $user['password'] = $request->password ? $request->password : $user->password;

         $user->save();
         return response()
            ->json(['message' => 'User updated','data'=>$user]);
       
    }
}
