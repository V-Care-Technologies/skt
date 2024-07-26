<?php

namespace App\Http\Controllers\Admin;

use App\Models\YarnVendor;
use App\Models\YarnVendorFirm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use Storage;

class YarnVendorController extends Controller
{

    public function index()
    {
        $result['vendors']=YarnVendor::where('is_deleted','0')->orderBy('id', 'DESC')->get();

        return view('admin.yarn_vendor.vendor',$result);
    }

    public function manage_vendor(Request $request,$id='')
    {
        if($id>0){
            $arr=YarnVendor::where(['id'=>$id])->first(); 

            $result['code']=$arr->code;
            $result['name']=$arr->name;
            $result['gst_number']=$arr->gst_number;
            $result['mobile']=$arr->mobile;
            $result['email']=$arr->email;
            $result['pay_followup_mobile']=$arr->pay_followup_mobile;
            $result['po_followup_mobile']=$arr->po_followup_mobile;
            $result['payment_terms']=$arr->payment_terms;
            $result['freight']=$arr->freight;
            $result['address']=$arr->address;
            $result['lat_long']=$arr->lat_long;
            $result['billing_through']=$arr->billing_through;
            $result['broker_company']=$arr->broker_company;
            $result['broker_name']=$arr->broker_name;
            $result['broker_mobile']=$arr->broker_mobile;
            $result['broker_gst']=$arr->broker_gst;
            $result['broker_email']=$arr->broker_email;
            $result['status']=$arr->status;
          
            $result['id']=$arr->id;

            $result['getfirms'] = YarnVendorFirm::where('yarn_vendor_id', $id)->get();
           
        }else{
            $result['code']='SKT-'.date('Ymdhis');
            $result['name']='';
            $result['gst_number']='';
            $result['mobile']='';
            $result['email']='';
            $result['pay_followup_mobile']='';
            $result['po_followup_mobile']='';
            $result['payment_terms']='';
            $result['freight']='';
            $result['address']='';
            $result['lat_long']='';
            $result['billing_through']='';
            $result['broker_company']='';
            $result['broker_name']='';
            $result['broker_mobile']='';
            $result['broker_gst']='';
            $result['broker_email']='';
            $result['status']="";
            
            $result['id']=0;

            $result['getfirms'] = [];
        }

        return view('admin.yarn_vendor.manage_vendor',$result);
    }

    public function manage_vendor_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'required',
        ], [
            'name.required' => 'The vendor name is required.',
            'mobile.required' => 'The mobile number is required.',
        ]);
        
        if ($validator->fails()) {
            echo json_encode(array('status'=>0,'message'=>$validator->errors()->first()));
            return;
        }    
        
        try {

        if($request->post('id')>0){
            $model=YarnVendor::find($request->post('id'));
            $model->updated_by = session('ADMIN_ID');
            $model->updated_at=date('Y-m-d H:i:s');
            $msg="Yarn Vendor updated";

        }else{
            $model=new YarnVendor();
            $model->created_by = session('ADMIN_ID');
            $model->created_at=date('Y-m-d H:i:s');
            $model->code='SKT-'.date('Ymdhis');
            $msg="Yarn Vendor inserted";
        }
        
        $model->name=$request->post('name'); 
        $model->gst_number=$request->post('gst_number');
        $model->mobile=$request->post('mobile');  
        $model->email=$request->post('email');
        $model->pay_followup_mobile=$request->post('pay_followup_mobile'); 
        $model->po_followup_mobile=$request->post('po_followup_mobile');
        $model->payment_terms=$request->post('payment_terms'); 
        $model->freight=$request->post('freight');
        $model->billing_through=$request->post('billing_through'); 
        $model->lat_long=$request->post('lat_long');
        $model->address=$request->post('address');  
        $model->broker_company=$request->post('broker_company');
        $model->broker_name=$request->post('broker_name'); 
        $model->broker_mobile=$request->post('broker_mobile');
        $model->broker_gst=$request->post('broker_gst');
        $model->broker_email=$request->post('broker_email');  
        $model->status=$request->post('status'); 
       
        $model->save();
        
        // Handle Firm
        if ($request->filled('firm_ids')) {
            $firmIds = $request->input('firm_ids');
            $firmVendor = $request->input('firm_vendor');
            $firmGST = $request->input('firm_gst');
           
            foreach ($firmIds as $index => $firmId) {
                $firm = YarnVendorFirm::findOrNew($firmId);
                if (!empty($firmVendor[$index])) {
                    $firm->yarn_vendor_id = $model->id;
                    $firm->vendor_name = $firmVendor[$index];
                    $firm->gst = $firmGST[$index];

                    if ($firm->exists) {
                        $firm->updated_by = session('ADMIN_ID');
                        $firm->updated_at=date('Y-m-d H:i:s');
                    } else {
                        $firm->created_by = session('ADMIN_ID');
                        $firm->created_at=date('Y-m-d H:i:s');
                    }

                    $firm->save();
                }
            }
        }

        echo json_encode(array('status'=>1,'message'=>$msg));

        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Some Error Occurred...']);
        }

    }


    public function delete(Request $request){
       $id = $request->post('id');
       $model=YarnVendor::find($id);
       $model->is_deleted='1';
       $model->save();

       YarnVendorFirm::where('yarn_vendor_id',$id)->delete();
       
       echo json_encode(array('status'=>1,'message'=>'Data'));
    } 

    public function deletefirm(Request $request){
        $id = $request->post('id');
       
        YarnVendorFirm::where('id',$id)->delete();
        
        echo json_encode(array('status'=>1,'message'=>'Data'));
     } 
    
}

?>