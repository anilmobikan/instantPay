<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Board;
use App\Models\Task;

class TaskController extends Controller
{
     public function store(Request $request)
    {
          $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'board_id' => 'required|integer|max:11',
        ]);
                    
        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $task = Task::create($request->all());
          return response()
            ->json(['message' => 'Task created','data'=>$task]);

    }

         public function edit($id)
    {

        $task = Task::find($id);
        if(!empty($task)){
             return response()
            ->json(['message' => 'task detail','data'=>$task]);
        }else{
             return response()
            ->json(['message' => 'no board found','data'=>$task]);
        }
        
    }

           public function update(Request $request,$id)
    {
        
            $validator = Validator::make($request->all(),[
               'name' => 'string|max:255',
            'board_id' => 'integer|max:11',
        ]);
                    
        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $task = Task::find($id);
       
        if(!empty($task)){

             $task['name'] = $request->name ? $request->name : $task->name;
             $task['description'] = $request->description ? $request->description : $task->description;
             $task['board_id'] = $request->board_id ? $request->board_id : $task->board_id;
              if($task->save()){
                return response()
            ->json(['message' => 'task updated','data'=>$task]);
             }else{
            return response()
            ->json(['message' => 'task not updated','data'=>$task]);
             }
             
            }else{
                 return response()
                ->json(['message' => 'no task found','data'=>$task]);
            }
        }

    public function destroy($id)
    {
        $task = Task::find($id);
       
         if(!empty($task)){
              if($task->delete()){
                return response()
            ->json(['message' => 'Task deleted']);
             }else{
            return response()
            ->json(['message' => 'Task not updated']);
             }
             
            }else{
                 return response()
                ->json(['message' => 'no task found']);
            }
    }
}
