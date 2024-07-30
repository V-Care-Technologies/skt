<?php

namespace App\Http\Controllers\Admin;

use App\Models\YarnVendor;
use App\Models\YarnProduct;
use App\Models\YarnProductVendor;
use App\Models\YarnProductVendorDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use Storage;

class YarnProductController extends Controller
{

    public function index()
    {
        $result['products']=YarnProduct::where('is_deleted','0')->orderBy('id', 'DESC')->get();

        return view('admin.yarn_product.product',$result);
    }

    public function manage_product(Request $request,$id='')
    {
        if($id>0){
            $arr=YarnProduct::where(['id'=>$id])->first(); 

            $result['skt_yarn_name']=$arr->skt_yarn_name;
            $result['gst']=$arr->gst;
            $result['hsn_code']=$arr->hsn_code;
            $result['status']=$arr->status;
          
            $result['id']=$arr->id;

            $result['product_record'] = YarnProductVendor::where('yarn_product_id', $id)->where('is_deleted',0)->get();
            
        }else{
            $result['skt_yarn_name']='';
            $result['gst']='';
            $result['hsn_code']='';
            $result['status']="";
            
            $result['id']=0;

            $result['product_record'] = [];
        }
        $result['getVendors'] = YarnVendor::where('is_deleted', 0)->where('status', 1)->get();

        return view('admin.yarn_product.add_product',$result);
    }

    public function manage_product_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'skt_yarn_name' => 'required'
        ], [
            'skt_yarn_name.required' => 'The skt yarn name is required.'
        ]);
        
        if ($validator->fails()) {
            echo json_encode(['status' => 0, 'message' => $validator->errors()->first()]);
            return;
        }

        try {
            if ($request->post('id') > 0) {
                $model = YarnProduct::find($request->post('id'));
                $model->updated_by = session('ADMIN_ID');
                $model->updated_at = date('Y-m-d H:i:s');
                $msg = "Yarn Product updated";
            } else {
                $model = new YarnProduct();
                $model->created_by = session('ADMIN_ID');
                $model->created_at = date('Y-m-d H:i:s');
                $msg = "Yarn Product inserted";
            }
            
            $model->skt_yarn_name = $request->post('skt_yarn_name'); 
            $model->gst = $request->post('gst');
            $model->hsn_code = $request->post('hsn_code');  
            $model->status = $request->post('status'); 
        
            $model->save();
            
            if($request->post('yarn_vendor_id')){
                foreach ($request->post('yarn_vendor_id') as $key => $yarnvendorId) {
                    if(!empty($request->post('product_id')[$key])){
                        $vendor = YarnProductVendor::find($request->post('product_id')[$key]);
                        if ($vendor) {
                            $vendor->vendor_yarn_name = $request->post('vendor_yarn_name')[$key];
                            $vendor->denier = $request->post('denier')[$key];
                            $vendor->status = $request->post('status');
                            $vendor->save();
                        }

                        if($request->post('shade_no')[$key]){
                            foreach($request->post('shade_no')[$key] as $key1 => $value1){
                                if(!empty($request->post('product_item_id')[$key][$key1])){
                                    $detail = YarnProductVendorDetail::find($request->post('product_item_id')[$key][$key1]);
                                    if ($detail) {
                                        $detail->shade_no = $value1;
                                        $detail->color = $request->post('color')[$key][$key1];
                                        $detail->moq = $request->post('moq')[$key][$key1];
                                        $detail->status = $request->post('status');
                                        $detail->save();
                                    }
                                } else {
                                    $detail = new YarnProductVendorDetail();
                                    $detail->yarn_product_id = $model->id;
                                    $detail->yarn_product_vendor_id = $vendor->id;
                                    $detail->shade_no = $value1;
                                    $detail->color = $request->post('color')[$key][$key1];
                                    $detail->moq = $request->post('moq')[$key][$key1];
                                    $detail->status = $request->post('status');
                                    $detail->save();
                                }
                            }
                        }
                    } else {
                        $vendor = new YarnProductVendor();
                        $vendor->yarn_product_id = $model->id;
                        $vendor->vendor_yarn_name = $request->post('vendor_yarn_name')[$key];
                        $vendor->denier = $request->post('denier')[$key];
                        $vendor->status = $request->post('status');
                        $vendor->save();

                        if($request->post('shade_no')[$key]){
                            foreach($request->post('shade_no')[$key] as $key1 => $value1){
                                $detail = new YarnProductVendorDetail();
                                $detail->yarn_product_id = $model->id;
                                $detail->yarn_product_vendor_id = $vendor->id;
                                $detail->shade_no = $value1;
                                $detail->color = $request->post('color')[$key][$key1];
                                $detail->moq = $request->post('moq')[$key][$key1];
                                $detail->status = $request->post('status');
                                $detail->save();
                            }
                        }
                    }
                }
            }

            echo json_encode(['status' => 1, 'message' => $msg]);

        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Some Error Occurred...']);
        }
    }



    public function delete(Request $request){
       $id = $request->post('id');
       $model=YarnProduct::find($id);
       $model->is_deleted='1';
       $model->save();

       $model1 = YarnProductVendor::where('yarn_product_id',$id)->first();
       $model1->is_deleted='1';
       $model1->save();

       YarnProductVendorDetail::where('yarn_product_id',$id)->delete();
       
       echo json_encode(array('status'=>1,'message'=>'Data'));
    } 

    public function deletevendor(Request $request){
        $id = $request->post('id');
       
        $model1 = YarnProductVendor::where('id',$id)->first();
        $model1->is_deleted='1';
        $model1->save();
        
        YarnProductVendorDetail::where('yarn_product_vendor_id',$id)->delete();

        echo json_encode(array('status'=>1,'message'=>'Data'));
     }
     
     public function deletevendordetail(Request $request){
        $id = $request->post('id');
       
        YarnProductVendorDetail::where('id',$id)->delete();

        echo json_encode(array('status'=>1,'message'=>'Data'));
     }
    
}

?>