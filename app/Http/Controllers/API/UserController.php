<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Board;
use App\Models\Task;
use DB;

class UserController extends Controller
{
    public function index(){

        $user = User::find(Auth::user()->id)->toArray();
     
        $boards = Board::where('user_id',Auth::user()->id)->get()->toArray();

         foreach($boards as $brd){
            $arr1 = $brd;
            $datatask = \App\Helpers\Helper::getTask($brd['id']);
            
           $arr[] =   array_merge($arr1,['tasks'=>$datatask]);           
         }
      $data =   array_merge($user,['boards'=>$arr]);

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
         $user['password'] = $request->password ? Hash::make($request->password) : $user->password;

         $user->save();
         return response()
            ->json(['message' => 'User updated','data'=>$user]);
       
    }
}
