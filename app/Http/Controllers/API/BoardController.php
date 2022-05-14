<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Board;

class BoardController extends Controller
{
    public function store(Request $request)
    {
         $user_id = Auth::user()->id;
          $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
        ]);
                    
        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $request['user_id'] = $user_id;
        $board = Board::create($request->all());
          return response()
            ->json(['message' => 'Board created','data'=>$board]);

    }

       public function edit($id)
    {

        $board = Board::find($id);
        if(!empty($board)){
             return response()
            ->json(['message' => 'board detail','data'=>$board]);
        }else{
             return response()
            ->json(['message' => 'no board found','data'=>$board]);
        }
        
    }


       public function update(Request $request,$id)
    {
        
            $validator = Validator::make($request->all(),[
            'name' => 'string|max:255',
        ]);
                    
        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $board = Board::find($id);
       
        if(!empty($board)){

             $board['name'] = $request->name ? $request->name : $board->name;
             $board['description'] = $request->description ? $request->description : $board->description;
              if($board->save()){
                return response()
            ->json(['message' => 'board updated','data'=>$board]);
             }else{
            return response()
            ->json(['message' => 'board not updated','data'=>$board]);
             }
             
            }else{
                 return response()
                ->json(['message' => 'no board found','data'=>$board]);
            }
        }

          public function destroy($id)
    {
        $board = Board::find($id);
        //dd($board);
         if(!empty($board)){
              if($board->delete()){
                return response()
            ->json(['message' => 'board deleted']);
             }else{
            return response()
            ->json(['message' => 'board not updated']);
             }
             
            }else{
                 return response()
                ->json(['message' => 'no board found']);
            }
      
    }
}
