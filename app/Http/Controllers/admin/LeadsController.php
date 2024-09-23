<?php

namespace App\Http\Controllers\Admin;

use App\Models\Leads;
use App\Models\LeadsLogs;
use App\Models\Tasks;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use Storage;

class LeadsController extends Controller
{

    public function index()
    {
        $result['leads']=Leads::orderBy('id', 'DESC')->get();

        return view('admin.leads.index',$result);
    }

    public function manage_leads(Request $request,$id='')
    {
        if($id>0){
            $arr=Leads::where(['id'=>$id])->first(); 

            $result['firm_name']=$arr->firm_name;
            $result['party_name']=$arr->party_name;
            $result['mobile_no']=$arr->mobile_no;
            $result['description']=$arr->description;          
            $result['id']=$arr->id;

           
        }else{
            $result['firm_name']="";
            $result['party_name']="";
            $result['mobile_no']="";
            $result['description']="";
            
            $result['id']=0;

        }
        $result['users']=DB::table('users')->where('status','1')->where('is_deleted','0')->get();
        $tasks=DB::table('tasks')->get();
        $t=[];
        foreach($tasks as $key=>$task){
           $t[$key]=explode(',',$task->labels);
        }
        // Step 1: Flatten the array
        $flattenedArray = array_merge(...$t);

        // Step 2: Remove duplicate values
        $distinctValues = array_unique($flattenedArray);

        $result["tasks"]=$distinctValues;
        return view('admin.leads.manage_leads',$result);
    }

    public function view_leads(Request $request,$id='')
    {
        if($id>0){
            $result['leads']=Leads::where(['id'=>$id])->first(); 

            $result['lastlog']=DB::table('leads_logs')
            ->leftJoin('users as a', 'a.id', '=', 'leads_logs.assign_to')
            ->leftJoin('users as b', 'b.id', '=', 'leads_logs.created_by')
            ->select(
                'leads_logs.*','b.name as cname','a.name as sname'
            )->orderby('leads_logs.id','desc')
            ->first();

            $result['leadslogs']=DB::table('leads_logs')
            ->leftJoin('users as a', 'a.id', '=', 'leads_logs.assign_to')
            ->leftJoin('users as b', 'b.id', '=', 'leads_logs.created_by')
            ->select(
                'leads_logs.*','b.name as cname','a.name as sname'
            )->orderby('leads_logs.id','asc')
            ->get();

            
            $result['users']=DB::table('users')->where('status','1')->where('is_deleted','0')->get();

        }
         return view('admin.leads.leadslogs',$result);
    }

    public function manage_leads_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firm_name' => 'required',
            'mobile_no' => 'required',
        ], [
            'firm_name.required' => 'The firm name is required.',
            'mobile_no.required' => 'The mobile number is required.',
        ]);
        
        if ($validator->fails()) {
            echo json_encode(array('status'=>0,'message'=>$validator->errors()->first()));
            return;
        }    
        
        try {

        if($request->post('id')>0){
            $model=Leads::find($request->post('id'));
            $model->updated_by = session('ADMIN_ID');
            $model->updated_at=date('Y-m-d H:i:s');
            $msg="Leads updated";

        }else{
            $model=new Leads();
            $model->created_by = session('ADMIN_ID');
            $model->created_at=date('Y-m-d H:i:s');
            $msg="Leads inserted";
        }
        
        $model->firm_name=$request->post('firm_name'); 
        $model->party_name=$request->post('party_name');
        $model->mobile_no=$request->post('mobile_no');  
        $model->description=$request->post('description');
       
        $model->save();
        
        // Handle Firm
        $leadslogs = new LeadsLogs();
        $leadslogs->leads_id = $model->id;
        $leadslogs->description = $request->post('description');    
        $leadslogs->followup_date = $request->post('followup_date');
        $leadslogs->dates = date('Y-m-d');
        $leadslogs->assign_to = $request->post('assign_to');       
        $leadslogs->created_by = session('ADMIN_ID');
        $leadslogs->created_at=date('Y-m-d H:i:s');       
        $leadslogs->save();

        if($request->post('generatetask')){
        $tasks = new Tasks();
        $tasks->description = $request->post('description');    
        $tasks->labels = implode(',',$request->post('task_label'));
        $tasks->task_date = $request->post('task_date');       
        $tasks->assign_to = $request->post('task_assign_to');       
        $tasks->created_by = session('ADMIN_ID');
        $tasks->created_at=date('Y-m-d H:i:s');       
        $tasks->save();
        }

        echo json_encode(array('status'=>1,'message'=>$msg));

        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Some Error Occurred...']);
        }

    }


    public function next_followup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'assign_to' => 'required',
            'description' => 'required',
        ], [
            'assign_to.required' => 'The Assign name is required.',
            'description.required' => 'The Description is required.',
        ]);
        
        if ($validator->fails()) {
            echo json_encode(array('status'=>0,'message'=>$validator->errors()->first()));
            return;
        }    
        
        try {

        if($request->post('id')>0){
            
      
        
        // Handle Firm
        $leadslogs = new LeadsLogs();
        $leadslogs->leads_id = $request->post('id');
        $leadslogs->description = $request->post('description');    
        $leadslogs->followup_date = $request->post('followup_date');
        $leadslogs->dates = $request->post('dates');
        $leadslogs->assign_to = $request->post('assign_to');       
        $leadslogs->created_by = session('ADMIN_ID');
        $leadslogs->created_at=date('Y-m-d H:i:s');       
        $leadslogs->save();
        $msg="next Follow Up inserted";
        }

        echo json_encode(array('status'=>1,'message'=>$msg));

        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Some Error Occurred...']);
        }

    }
    public function delete(Request $request){
       $id = $request->post('id');
       $model=Leads::find($id);
       $model->is_deleted='1';
       $model->save();

       LeadsLogs::where('leads_id',$id)->delete();
       
       echo json_encode(array('status'=>1,'message'=>'Data'));
    } 

    public function deleteleadslogs(Request $request){
        $id = $request->post('id');
       
        LeadsLogs::where('id',$id)->delete();
        
        echo json_encode(array('status'=>1,'message'=>'Data'));
     } 
    
}

?>