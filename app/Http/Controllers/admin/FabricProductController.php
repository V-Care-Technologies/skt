<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\YarnInward;
use App\Models\FabricProduct;
use App\Models\FabricProductProcess;
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
            $result['po_det']=DB::table('fabric_product_process')->where('fabric_product_id',$id)->where('is_deleted','0')->get(); 
            
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
        $result['fabric_process_vendors']=DB::table('fabric_process_vendor')->where('is_deleted','0')->where('status','1')->get();
        $result['fabric_types']=DB::table('mst_fabric_type')->where('is_deleted','0')->where('status','1')->get();
        $result['fabric_propertys']=DB::table('mst_fabric_property')->where('is_deleted','0')->where('status','1')->get();
        $result['fabric_process']=DB::table('fabric_process')->where('is_deleted','0')->where('status','1')->get();
        
        return view('admin.fabric_product.manage_fabricproduct',$result);
    }

  

    public function manage_fabricproduct_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'skt_name' => 'required'
        ], [
            'skt_name.required' => 'The SKT name is required.'
        ]);
        
        if ($validator->fails()) {
            echo json_encode(['status' => 0, 'message' => $validator->errors()->first()]);
            return;
        }

        //try {
        
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

            if ($request->hasFile('images')) {
                // Handle image file upload
                $imageFile = $request->file('images');
                $imageFileName = 'images_' . time() . '.' . $imageFile->getClientOriginalExtension();
    
                // Specify the directory where you want to save the image
                $imageDirectory = public_path('fabric_product');
    
                // Move the uploaded file to the specified directory
                $imageFile->move($imageDirectory, $imageFileName);
    
                // Save the image file name in the database
                $images = $imageFileName;
            }else{
                $images =$request->post('images_hidden');
            }


            $model->skt_name = $request->post('skt_name');
            $model->mst_fabric_type_id = $request->post('mst_fabric_type_id');
            $model->hsn_code = $request->post('hsn_code');
            $model->wt_before = $request->post('wt_before');
            $model->wt_after = $request->post('wt_after');
            $model->cut_before = $request->post('cut_before');
            $model->cut_after = $request->post('cut_after');
            $model->panna_before = $request->post('panna_before');
            $model->panna_after = $request->post('panna_after');
            $model->blouse_before = $request->post('blouse_before');
            $model->blouse_after = $request->post('blouse_after');
            $model->gst = $request->post('gst_main');
            $model->colors = implode('|',$request->post('colors'));
            $model->images = $images;
            $model->mst_fabric_property_id = $request->post('mst_fabric_property_id');
            $model->status = $request->post('status');
            $model->save();
            
            if($request->post('process')){
                if($request->post('process')){
                    foreach($request->post('process')as $key1 => $value1){
                        //$prodet = DB::table('fabric_product_process')->where('id',$value1)->first();
                        if(!empty($request->post('product_process_id')[$key1])){
                            $detail = FabricProductProcess::find($request->post('product_process_id')[$key1]);
                            if ($detail) {
                                $detail->fabric_product_id = $value1;
                                $detail->process_id = $value1;
                                $detail->process_vendor_id = "";
                                $detail->rate = $request->post('rate')[$key1];
                                $detail->gst = $request->post('gst')[$key1];
                                $detail->timeline = $request->post('timeline')[$key1];
                                $detail->save();
                            }
                        } else {
                            $detail = new FabricProductProcess();
                            $detail->fabric_product_id = $value1;
                            $detail->process_id = $value1;
                            $detail->process_vendor_id = "";
                            $detail->rate = $request->post('rate')[$key1];
                            $detail->gst = $request->post('gst')[$key1];
                            $detail->timeline = $request->post('timeline')[$key1];
                            $detail->save();
                        }
                    }
                }
                   
            }    

            echo json_encode(['status' => 1, 'message' => $msg]);

        // } catch (\Exception $e) {
        //     return response()->json(['status' => 0, 'message' => 'Some Error Occurred...']);
        // }
    }



    public function delete(Request $request){

       $id = $request->post('id');
       
       $model=FabricProduct::find($id);
       $model->is_deleted='1';
       $model->save();


       echo json_encode(array('status'=>1,'message'=>'Data'));
    } 

    public function deletepodetail(Request $request){

        $id = $request->post('id');
        $model=FabricProductProcess::find($id);
        $model->is_deleted='1';
        $model->save();

 
        echo json_encode(array('status'=>1,'message'=>'Data'));
     }
    
}


?>