<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\YarnPo;
use App\Models\YarnPoDetail;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use Storage;

class YarnPoController extends Controller
{

    public function index()
    {
        $result['po']=DB::table('yarn_po')
        ->leftJoin('yarn_vendor', 'yarn_vendor.id', '=', 'yarn_po.yarn_vendor_id')
        ->leftJoin('yarn_product', 'yarn_product.id', '=', 'yarn_po.yarn_product_id')
        ->select(
            'yarn_po.*',
            'yarn_vendor.name',
            'yarn_product.skt_yarn_name'
        )
        ->get();

        return view('admin.yarn_po.po',$result);
    }

    public function manage_po(Request $request,$id='')
    {
        if($id>0){
            $arr=DB::table('yarn_po')
            ->leftJoin('yarn_vendor', 'yarn_vendor.id', '=', 'yarn_po.yarn_vendor_id')
            ->leftJoin('yarn_product', 'yarn_product.id', '=', 'yarn_po.yarn_product_id')
            ->select(
                'yarn_po.*',
                'yarn_vendor.name',
                'yarn_product.skt_yarn_name'
            )
            ->where(['yarn_po.id'=>$id])->first(); 

            // $result['skt_yarn_name']=$arr->skt_yarn_name;
            // $result['gst']=$arr->gst;
            // $result['hsn_code']=$arr->hsn_code;
            // $result['status']=$arr->status;

            $result['po_number']=$arr->po_number;
            $result['po_date']=$arr->date;
            $result['yarn_vendor_id']=$arr->yarn_vendor_id;
            $result['del_date']=$arr->delivery_date;
            $result['yarn_id']=$arr->yarn_product_id;
            $result['denier']=$arr->denier;
            $result['freight']=$arr->freight;
            $result['gst']=$arr->gst_per;
            $result['hsn']=$arr->hsn_code;
            $result['status']=$arr->status;
            $result['yarn_type']=$arr->inward_format;
            $result['rola_qty']=$arr->rola_qty;
            $result['rate']=$arr->rate;
            $result['tot_amt']=$arr->total_amt;
            $result['del_address']=$arr->delivery_address;
            $result['remarks']=$arr->remarks;
            $result['tot_qty']=$arr->tot_qty;
            $result['po_det']=DB::table('yarn_po_detail')->where('yarn_po_id', $id)->where('is_deleted',0)->get();

            $result['products']=DB::table('yarn_product_vendor_detail')->where('yarn_product_id', $arr->yarn_product_id)->where('yarn_product_vendor_id', $arr->yarn_vendor_id)->where('is_deleted',0)->get();
          
            $result['id']=$arr->id;

            //$result['product_record'] = DB::table('yarn_po_detail')->where('yarn_po_id', $id)->where('is_deleted',0)->get();
            
        }else{
            $result['po_number']=date('ymdhis');
            $result['po_date']='';
            $result['yarn_vendor_id']='';
            $result['del_date']="";
            $result['yarn_id']='';
            $result['denier']='';
            $result['freight']='';
            $result['gst']="";
            $result['hsn']='';
            $result['status']='';
            $result['yarn_type']='';
            $result['rola_qty']="";
            $result['rate']='';
            $result['tot_amt']='';
            $result['del_address']='';
            $result['remarks']="";
            $result['tot_qty']="";
            $result['po_det']=[];
            
            $result['id']=0;

           // $result['product_record'] = [];
        }
        $result['getVendors'] = DB::table('yarn_vendor')->where('is_deleted', 0)->where('status', 1)->get();

        return view('admin.yarn_po.manage_po',$result);
    }

    public function getYarn(Request $request)
    {
        $id=$request->post('id');
        $pid=$request->post('pid');

        $yarns = DB::table('yarn_product_vendor')
        ->leftJoin('yarn_product', 'yarn_product.id', '=', 'yarn_product_vendor.yarn_product_id')
        ->select(
            'yarn_product_vendor.*',
            'yarn_product.skt_yarn_name',
            'yarn_product.gst',
            'yarn_product.hsn_code',
        )
        ->where('yarn_product_vendor.yarn_vendor_id', $id)->where('yarn_product_vendor.is_deleted', 0)->where('yarn_product_vendor.status', 1)->get();
        
        $html='<option value="" >--Select--</option>';
        foreach($yarns as $y){
            $select="";
            if($pid==$y->yarn_product_id){
                $select="selected";
            }
            $html.='<option value="'.$y->yarn_product_id.'" '.$select.' data-id="'.$y->denier.'" data-gst="'.$y->gst.'" data-hsn="'.$y->hsn_code.'">'.$y->skt_yarn_name.'</option>';
        }
        echo json_encode(array('status'=>1,'message'=>'Data','data'=>$html));

    }

    public function getYarnDetails(Request $request)
    {
        $id=$request->post('id');
        $vid=$request->post('vid');
        $poid=$request->post('poid');
        $result['po_det']=DB::table('yarn_po_detail')->where('yarn_po_id', $poid)->where('is_deleted',0)->get();

        $result['products'] = DB::table('yarn_product_vendor_detail')
        ->where('yarn_product_id', $id)->where('yarn_product_vendor_id',$vid)->where('is_deleted', 0)->where('status', 1)->get();
       
        $html = view('admin.yarn_po.ajax')->with($result)->render();

        echo json_encode(array('status'=>1,'message'=>'Data','data'=>$html));

    }

    public function manage_po_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'yarn_vendor_id' => 'required'
        ], [
            'yarn_vendor_id.required' => 'The yarn vendor name is required.'
        ]);
        
        if ($validator->fails()) {
            echo json_encode(['status' => 0, 'message' => $validator->errors()->first()]);
            return;
        }

        try {
            if ($request->post('id') > 0) {
                $model = YarnPo::find($request->post('id'));
                $model->updated_by = session('ADMIN_ID');
                $model->updated_at = date('Y-m-d H:i:s');
                $msg = "Yarn Product updated";
            } else {
                $model = new YarnPo();
                $model->created_by = session('ADMIN_ID');
                $model->created_at = date('Y-m-d H:i:s');
                $msg = "Yarn Product inserted";
            }
            
            $model->po_number = $request->post('po_number'); 
            $model->date = $request->post('po_date'); 
            $model->yarn_vendor_id = $request->post('yarn_vendor_id'); 
            $model->delivery_date = $request->post('delivery_date'); 
            $model->yarn_product_id = $request->post('yarn_id');
            $model->gst_per = $request->post('gst');
            $model->hsn_code = $request->post('hsn'); 
            $model->denier = $request->post('denier');
            $model->freight = $request->post('freight');  
            $model->status = $request->post('status'); 
            $model->tot_qty = $request->post('tot_qty'); 
            $model->rate = $request->post('rate');
            $model->total_amt = $request->post('tot_amt');
            $model->inward_format = $request->post('yarn_inward');
            $model->rola_qty = $request->post('rola_qty');
            $model->delivery_address = $request->post('del_address');
            $model->remarks = $request->post('remarks');
            $model->save();
            
            if($request->post('shade_no')){
                if($request->post('shade_no')){
                    foreach($request->post('shade_no')as $key1 => $value1){
                        $prodet = DB::table('yarn_product_vendor_detail')->where('id',$value1)->first();
                        if(!empty($request->post('po_detail_id')[$key1])){
                            $detail = YarnPoDetail::find($request->post('po_detail_id')[$key1]);
                            if ($detail) {
                                $detail->yarn_product_vendor_detail_id = $value1;
                                $detail->shade_no = $prodet->shade_no;
                                $detail->color = $request->post('color')[$key1];
                                $detail->qty = $request->post('qty')[$key1];
                                $detail->save();
                            }
                        } else {
                            $detail = new YarnPoDetail();
                            $detail->yarn_po_id = $model->id;
                            $detail->yarn_product_vendor_detail_id = $value1;
                            $detail->shade_no = $prodet->shade_no;
                            $detail->color = $request->post('color')[$key1];
                            $detail->qty = $request->post('qty')[$key1];
                            $detail->save();
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
       
       $model=YarnPo::find($id);
       $model->is_deleted='1';
       $model->save();

       $model1=YarnPoDetail::find('yarn_po_id',$id);
       $model1->is_deleted='1';
       $model1->save();

       echo json_encode(array('status'=>1,'message'=>'Data'));
    } 

    public function deletepodetail(Request $request){

        $id = $request->post('id');
        $model=YarnPoDetail::find($id);
        $model->is_deleted='1';
        $model->save();

 
        echo json_encode(array('status'=>1,'message'=>'Data'));
     }

    
}

?>