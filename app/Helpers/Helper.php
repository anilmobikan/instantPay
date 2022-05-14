<?php
namespace App\Helpers;
use App\Models\Task;

class Helper
{
    public static function GetTask($id)
    {
      $data  = [];
      $data = Task::where('board_id',$id)->get()->toArray();
      if($data){
        return $data;
      }else{
        return [];
      }
    }
}