<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\YarnInward;
use App\Models\FabricProcess;
use App\Models\YarnInwardDetail;
use App\Models\YarnPoDetail;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use Storage;


class FabricProcessController extends Controller
{

    public function index()
    {
        $result['process']=DB::table('fabric_process')
        ->get();

        return view('admin.fabric_process.index',$result);
    }



    public function manage_fabricprocess(Request $request,$id='')
    {
    
        if($id>0){
            $arr=DB::table('fabric_process')
            
            ->where(['id'=>$id])->first(); 
            
            $result['title']=$arr->title;
            $result['status']=$arr->status;
            $result['id']=$arr->id;

            
        }else{
            $result['title']="";
            $result['status']="";
            $result['id']="0";
        }
        
        return view('admin.fabric_process.manage_fabricprocess',$result);
    }

  

    public function manage_fabricprocess_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ], [
            'title.required' => 'The Process name is required.'
        ]);
        
        if ($validator->fails()) {
            echo json_encode(['status' => 0, 'message' => $validator->errors()->first()]);
            return;
        }

        try {
        
            if ($request->post('id') > 0) {
                $model = FabricProcess::find($request->post('id'));
                $model->updated_by = session('ADMIN_ID');
                $model->updated_at = date('Y-m-d H:i:s');
                $msg = "Fabric Process updated";
            } else {
                $model = new FabricProcess();
                $model->created_by = session('ADMIN_ID');
                $model->created_at = date('Y-m-d H:i:s');
                $msg = "Fabric Process inserted";
            }
            $model->title = $request->post('title');
            $model->status = $request->post('status');
            $model->save();
            
            echo json_encode(['status' => 1, 'message' => $msg]);

        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Some Error Occurred...']);
        }
    }



    public function delete(Request $request){

       $id = $request->post('id');
       
       $model=FabricProcess::find($id);
       $model->is_deleted='1';
       $model->save();


       echo json_encode(array('status'=>1,'message'=>'Data'));
    } 

    
}


?>