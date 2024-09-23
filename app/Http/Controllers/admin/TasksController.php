<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tasks;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use Storage;

class TasksController extends Controller
{

    public function index()
    {
        $result['tasks']=DB::table('tasks')
            ->leftJoin('users as a', 'a.id', '=', 'tasks.assign_to')
            ->leftJoin('users as b', 'b.id', '=', 'tasks.created_by')
            ->select(
                'tasks.*','b.name as cname','a.name as sname'
            )->orderby('tasks.id','desc')
            ->get();

        return view('admin.tasks.index',$result);
    }

    public function manage_tasks(Request $request,$id='')
    {
        if($id>0){
            $arr=Tasks::where(['id'=>$id])->first(); 

            $result['title']=$arr->title;
            $result['priority']=$arr->priority;
            $result['labels']=$arr->labels;
            $result['description']=$arr->description; 
            $result['status']=$arr->status; 
            $result['assign_to']=$arr->assign_to;         
            $result['task_date']=$arr->task_date;          
            $result['id']=$arr->id;

           
        }else{
            $result['title']="";
            $result['priority']="";
            $result['labels']="";
            $result['description']=""; 
            $result['status']=""; 
            $result['assign_to']="";         
            $result['task_date']="";   
            
            $result['id']=0;

        }
        $result['users']=DB::table('users')->where('status','1')->where('is_deleted','0')->get();
        $tasks=DB::table('tasks')->get();
        foreach($tasks as $key=>$task){
            $t[$key]=explode(',',$task->labels);
         }
         
        $flattenedArray = array_merge(...$t);

        $distinctValues = array_unique($flattenedArray);

        $result["tasks"]=$distinctValues;
        
        
        
        return view('admin.tasks.manage_tasks',$result);
    }


    public function manage_tasks_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'assign_to' => 'required',
        ], [
            'title.required' => 'The title is required.',
            'assign_to.required' => 'The assign is required.',
        ]);
        
        if ($validator->fails()) {
            echo json_encode(array('status'=>0,'message'=>$validator->errors()->first()));
            return;
        }    
        
        try {

        if($request->post('id')>0){
            $model=Tasks::find($request->post('id'));
            $model->updated_by = session('ADMIN_ID');
            $model->updated_at=date('Y-m-d H:i:s');
            $msg="Tasks updated";

        }else{
            $model=new Tasks();
            $model->created_by = session('ADMIN_ID');
            $model->created_at=date('Y-m-d H:i:s');
            $msg="Tasks inserted";
        }
        
        $model->description = $request->post('description');    
        $model->title = $request->post('title');    
        $model->labels = implode(',',$request->post('labels'));
        $model->task_date = $request->post('task_date');       
        $model->assign_to = $request->post('assign_to');  
        $model->priority = $request->post('priority');  
        $model->status = $request->post('status');       
        $model->created_by = session('ADMIN_ID');
        $model->created_at=date('Y-m-d H:i:s');       
        $model->save();
      

        

        echo json_encode(array('status'=>1,'message'=>$msg));

        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Some Error Occurred...']);
        }

    }


    public function delete(Request $request){
       $id = $request->post('id');
       $model=Tasks::find($id);
       $model->is_deleted='1';
       $model->save();

       
       
       echo json_encode(array('status'=>1,'message'=>'Data'));
    } 


}

?>