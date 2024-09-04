<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\YarnInward;
use App\Models\FabricProduct;
use App\Models\YarnInwardDetail;
use App\Models\YarnPoDetail;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use Storage;


class FabricProductController extends Controller
{

    public function index()
    {
        $result['product']=DB::table('fabric_product')
        ->get();

        return view('admin.fabric_product.index',$result);
    }



    public function manage_fabricproduct(Request $request,$id='')
    {
    
        if($id>0){
            $arr=DB::table('fabric_product')
            
            ->where(['id'=>$id])->first(); 
            
            $result['skt_name']=$arr->skt_name;
            $result['mst_fabric_type_id']=$arr->mst_fabric_type_id;
            $result['hsn_code']=$arr->hsn_code;
            $result['wt_before']=$arr->wt_before;
            $result['wt_after']=$arr->wt_after;
            $result['panna_before']=$arr->panna_before;
            $result['panna_after']=$arr->panna_after;
            $result['cut_before']=$arr->cut_before;
            $result['cut_after']=$arr->cut_after;
            $result['blouse_before']=$arr->blouse_before;
            $result['blouse_after']=$arr->blouse_after;
            $result['mst_fabric_property_id']=$arr->mst_fabric_property_id;
            $result['gst']=$arr->gst;
            $result['images']=$arr->images;
            $result['colors']=$arr->colors;
            $result['status']=$arr->status;
            $result['id']=$arr->id;
            $result['po_det']=[];
            
        }else{
            $result['skt_name']="";
            $result['mst_fabric_type_id']="";
            $result['hsn_code']="";
            $result['wt_before']="";
            $result['wt_after']="";
            $result['panna_before']="";
            $result['panna_after']="";
            $result['cut_before']="";
            $result['cut_after']="";
            $result['blouse_before']="";
            $result['blouse_after']="";
            $result['mst_fabric_property_id']="";
            $result['gst']="";
            $result['images']="";
            $result['colors']="";
            $result['status']="";
            $result['po_det']=[];
            $result['id']="0";
        }
        $result['fabric_types']=DB::table('mst_fabric_type')->where('is_deleted','0')->where('status','1')->get();
        $result['fabric_propertys']=DB::table('mst_fabric_property')->where('is_deleted','0')->where('status','1')->get();

        
        return view('admin.fabric_product.manage_fabricproduct',$result);
    }

  

    public function manage_fabricproduct_process(Request $request)
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
                $model = FabricProduct::find($request->post('id'));
                $model->updated_by = session('ADMIN_ID');
                $model->updated_at = date('Y-m-d H:i:s');
                $msg = "Fabric Product updated";
            } else {
                $model = new FabricProduct();
                $model->created_by = session('ADMIN_ID');
                $model->created_at = date('Y-m-d H:i:s');
                $msg = "Fabric Product inserted";
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
       
       $model=FabricProduct::find($id);
       $model->is_deleted='1';
       $model->save();


       echo json_encode(array('status'=>1,'message'=>'Data'));
    } 

    
}


?>