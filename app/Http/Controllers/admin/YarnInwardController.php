<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\RolaInward;
use Illuminate\Http\Request;
use App\Models\YarnInward;
use App\Models\YarnInwardDetail;
use App\Models\YarnPoDetail;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use Storage;

class YarnInwardController extends Controller
{

    public function index()
    {
        $result['inward']=DB::table('yarn_inward')
        ->leftJoin('yarn_po', 'yarn_po.id', '=', 'yarn_inward.yarn_po_id')
        ->leftJoin('yarn_vendor_firms', 'yarn_vendor_firms.id', '=', 'yarn_inward.challan_id')
        ->leftJoin('yarn_product', 'yarn_product.id', '=', 'yarn_inward.yarn_product_id')
        ->leftJoin('yarn_inward_detail', 'yarn_inward_detail.yarn_inward_id', '=', 'yarn_inward.id')
        ->select(
            'yarn_inward.*',
            'yarn_po.po_number',
            'yarn_vendor_firms.vendor_name',
            'yarn_product.skt_yarn_name',
            DB::raw('SUM(yarn_inward_detail.inward_qty) as totqty')
        )
        ->groupBy('yarn_inward.id')
        ->get();

        return view('admin.yarn_inward.inward',$result);
    }

    public function add_inward(Request $request,$id='')
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
            $result['yarn_vendor_name']=$arr->name;
            $result['yarn_name']=$arr->skt_yarn_name;
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
            $result['po_det']=DB::table('yarn_po_detail')->select('*',DB::raw('(qty - rec_qty) as pqty'))->where('yarn_po_id', $id)->whereRaw('(qty - rec_qty) > 0')->where('is_deleted',0)->get();
            $result['firms']=DB::table('yarn_vendor_firms')->where('yarn_vendor_id', $arr->yarn_vendor_id)->get();

            //$result['products']=DB::table('yarn_product_vendor_detail')->where('yarn_product_id', $arr->yarn_product_id)->where('yarn_product_vendor_id', $arr->yarn_vendor_id)->where('is_deleted',0)->get();
          
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
        //$result['getVendors'] = DB::table('yarn_vendor')->where('is_deleted', 0)->where('status', 1)->get();

        return view('admin.yarn_inward.add_inward',$result);
    }

    public function manage_inward(Request $request,$id='')
    {
    
        if($id>0){
            $arr=DB::table('yarn_inward')
            ->leftJoin('yarn_po', 'yarn_po.id', '=', 'yarn_inward.yarn_po_id')
            ->leftJoin('yarn_vendor', 'yarn_vendor.id', '=', 'yarn_inward.yarn_vendor_id')
            ->leftJoin('yarn_vendor_firms', 'yarn_vendor_firms.id', '=', 'yarn_inward.challan_id')
            ->leftJoin('yarn_product', 'yarn_product.id', '=', 'yarn_inward.yarn_product_id')
            ->select(
                'yarn_inward.*',
                'yarn_vendor_firms.vendor_name',
                'yarn_vendor.name',
                'yarn_product.skt_yarn_name',
                'yarn_po.rate',
                'yarn_po.total_amt',
                'yarn_po.tot_qty'
            )
            ->where(['yarn_inward.id'=>$id])->first(); 
            
            // $result['skt_yarn_name']=$arr->skt_yarn_name;
            // $result['gst']=$arr->gst;
            // $result['hsn_code']=$arr->hsn_code;
            // $result['status']=$arr->status;
            $result['challan_id']=$arr->challan_id;
            $result['yarn_po_id']=$arr->yarn_po_id;
            $result['po_number']=$arr->po_inward_no;
            $result['challan_no']=$arr->challan_no;
            $result['challan_date']=$arr->challan_date;
            $result['yarn_vendor_id']=$arr->yarn_vendor_id;
            $result['yarn_vendor_name']=$arr->name;
            $result['received_date']=$arr->received_date;
            $result['yarn_id']=$arr->yarn_product_id;
            $result['yarn_name']=$arr->skt_yarn_name;
            $result['denier']=$arr->denier;            
            $result['status']=$arr->status;
            $result['yarn_type']=$arr->yarn_inward_format;
            $result['rola_qty']=$arr->rola_qty;
            $result['rate']=$arr->rate;
            $result['tot_amt']=$arr->total_amt;
            $result['remarks']=$arr->remarks;
            $result['tot_qty']=$arr->tot_qty;
            $result['denier_issue']=$arr->denier_issue; 
            $result['packaging_issue']=$arr->packaging_issue; 
            $result['coning_issue']=$arr->coning_issue; 
            $result['inward_det']=DB::table('yarn_inward_detail')->where('yarn_inward_id', $id)->where('is_deleted',0)->get();
            $result['firms']=DB::table('yarn_vendor_firms')->where('yarn_vendor_id', $arr->yarn_vendor_id)->get();
            //$result['products']=DB::table('yarn_product_vendor_detail')->where('yarn_product_id', $arr->yarn_product_id)->where('yarn_product_vendor_id', $arr->yarn_vendor_id)->where('is_deleted',0)->get();
          
            $result['id']=$arr->id;

            //$result['product_record'] = DB::table('yarn_po_detail')->where('yarn_po_id', $id)->where('is_deleted',0)->get();
            
        }
        //$result['getVendors'] = DB::table('yarn_vendor')->where('is_deleted', 0)->where('status', 1)->get();

        return view('admin.yarn_inward.manage_inward',$result);
    }


    public function manage_inward_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'challan_id' => 'required'
        ], [
            'challan_id.required' => 'The yarn Challan name is required.'
        ]);
        
        if ($validator->fails()) {
            echo json_encode(['status' => 0, 'message' => $validator->errors()->first()]);
            return;
        }

        try {
            if ($request->post('id') > 0) {
                $model = YarnInward::find($request->post('id'));
                $model->updated_by = session('ADMIN_ID');
                $model->updated_at = date('Y-m-d H:i:s');
                $msg = "Yarn Inward updated";
            } else {
                $model = new YarnInward();
                $model->created_by = session('ADMIN_ID');
                $model->created_at = date('Y-m-d H:i:s');
                $msg = "Yarn Inward inserted";

                $rolamodel = new RolaInward();
                $rolamodel->qty = $request->post('rola_qty');
                $rolamodel->is_auto = '1';
                $rolamodel->save();
            }
            $model->yarn_po_id = $request->post('yarn_po_id');
            $model->po_inward_no = $request->post('po_inward_no');             
            $model->challan_id = $request->post('challan_id'); 
            $model->challan_no = $request->post('challan_no');
            $model->challan_date = $request->post('challan_date'); 
            $model->yarn_vendor_id = $request->post('yarn_vendor_id'); 
            $model->received_date = $request->post('received_date'); 
            $model->yarn_product_id = $request->post('yarn_id');            
            $model->denier = $request->post('denier');  
            $model->status = $request->post('status'); 
            $model->yarn_inward_format = $request->post('yarn_inward');
            $model->rola_qty = $request->post('rola_qty');
            $model->remarks = $request->post('remarks');
            $model->denier_issue = $request->post('denier_issue');  
            $model->packaging_issue = $request->post('packaging_issue'); 
            $model->coning_issue = $request->post('coning_issue');
            $model->save();
            
                if($request->post('yarn_product_vendor_detail_id')){
                    foreach($request->post('yarn_product_vendor_detail_id')as $key1 => $value1){
                        //$prodet = DB::table('yarn_product_vendor_detail')->where('id',$value1)->first();
                        if(!empty($request->post('inward_detail_id')[$key1])){
                            $detail = YarnInwardDetail::find($request->post('inward_detail_id')[$key1]);
                            if ($detail) {
                                $detail->yarn_po_detail_id =$request->post('yarn_po_detail_id')[$key1];
                                $detail->yarn_product_vendor_detail_id = $value1;
                                $detail->shade_no = $request->post('shade_no')[$key1];
                                $detail->color = $request->post('color')[$key1];
                                $detail->qty = $request->post('qty')[$key1];
                                $detail->challan_qty = $request->post('challan_qty')[$key1];
                                $detail->inward_qty = $request->post('inward_qty')[$key1];
                                $detail->weight_diff = $request->post('weight_diff')[$key1]; 
                                $detail->weight_diff_per = $request->post('weight_diff_per')[$key1];
                                $detail->color_issue = $request->post('color_issue')[$key1];
                                $detail->weight_issue = $request->post('weight_issue')[$key1];
                                $detail->weight_per_issue = $request->post('weight_per_issue')[$key1];
                                $detail->status = $request->post('status_child')[$key1];
                                $detail->save();

                                $po = YarnPoDetail::find($request->post('yarn_po_detail_id')[$key1]);
                                if($request->post('status_child')[$key1]=='1'){
                                    $po->rec_qty = $request->post('challan_qty')[$key1];
                                }else{
                                    $po->rec_qty = $request->post('inward_qty')[$key1];
                                }
                                $po->save();
                            }
                        } else {
                            $detail = new YarnInwardDetail();
                            $detail->yarn_inward_id = $model->id;
                            $detail->yarn_po_detail_id =$request->post('yarn_po_detail_id')[$key1];
                            $detail->yarn_product_vendor_detail_id = $value1;
                            $detail->shade_no = $request->post('shade_no')[$key1];
                            $detail->color = $request->post('color')[$key1];
                            $detail->qty = $request->post('qty')[$key1];
                            $detail->challan_qty = $request->post('challan_qty')[$key1];
                            $detail->inward_qty = $request->post('inward_qty')[$key1];
                            $detail->weight_diff = $request->post('weight_diff')[$key1]; 
                            $detail->weight_diff_per = $request->post('weight_diff_per')[$key1];
                            $detail->color_issue = $request->post('color_issue')[$key1];
                            $detail->weight_issue = $request->post('weight_issue')[$key1];
                            $detail->weight_per_issue = $request->post('weight_per_issue')[$key1];
                            $detail->status = $request->post('status_child')[$key1];
                            $detail->save();

                            $po = YarnPoDetail::find($request->post('yarn_po_detail_id')[$key1]);
                            if($request->post('status_child')[$key1]=='1'){
                                $po->rec_qty = $request->post('challan_qty')[$key1];
                            }else{
                                $po->rec_qty = $request->post('inward_qty')[$key1];
                            }
                            $po->save();
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
       
       $model=YarnInward::find($id);
       $model->is_deleted='1';
       $model->save();

       $model1=YarnInwardDetail::find('yarn_po_id',$id);
       $model1->is_deleted='1';
       $model1->save();

       echo json_encode(array('status'=>1,'message'=>'Data'));
    } 

    public function deleteinwarddetail(Request $request){

        $id = $request->post('id');
        $model=YarnInwardDetail::find($id);
        $model->is_deleted='1';
        $model->save();

 
        echo json_encode(array('status'=>1,'message'=>'Data'));
     }

    
}

?>