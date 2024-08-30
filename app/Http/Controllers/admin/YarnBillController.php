<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\YarnInward;
use App\Models\YarnBill;
use App\Models\YarnInwardDetail;
use App\Models\YarnPoDetail;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use Storage;

class YarnBillController extends Controller
{

    public function index()
    {
        $result['bill']=DB::table('yarn_bill')
        ->leftJoin('yarn_po', 'yarn_po.id', '=', 'yarn_bill.yarn_po_id')
        ->leftJoin('yarn_vendor_firms', 'yarn_vendor_firms.id', '=', 'yarn_bill.bill_firm_id')
        ->leftJoin('yarn_product', 'yarn_product.id', '=', 'yarn_po.yarn_product_id')
        ->leftJoin('yarn_vendor', 'yarn_vendor_firms.yarn_vendor_id', '=', 'yarn_vendor.id')
        ->select(
            'yarn_bill.*',
            'yarn_po.po_number',
            'yarn_vendor_firms.vendor_name',
            'yarn_product.skt_yarn_name',
            'yarn_vendor.name',
        )
        ->get();

        return view('admin.yarn_bill.bill',$result);
    }



    public function manage_bill(Request $request,$id='')
    {
    
        if($id>0){
            $arr=DB::table('yarn_bill')
            ->leftJoin('yarn_po', 'yarn_po.id', '=', 'yarn_bill.yarn_po_id')
            ->leftJoin('yarn_vendor_firms', 'yarn_vendor_firms.id', '=', 'yarn_bill.bill_firm_id')
            ->leftJoin('yarn_product', 'yarn_product.id', '=', 'yarn_po.yarn_product_id')
            ->leftJoin('yarn_vendor', 'yarn_vendor_firms.yarn_vendor_id', '=', 'yarn_vendor.id')
            ->select(
                'yarn_bill.*',
                'yarn_po.po_number',
                'yarn_po.yarn_vendor_id',
                'yarn_vendor_firms.vendor_name',
                'yarn_product.skt_yarn_name',
                'yarn_vendor.name',
            )
            ->where(['yarn_bill.id'=>$id])->first(); 
            
            $result['yarn_vendor_id']=$arr->yarn_vendor_id;
            $result['bill_firm_id']=$arr->bill_firm_id;
            $result['yarn_po_id']=$arr->yarn_po_id;
            $result['bill_no']=$arr->bill_no;
            $result['bill_date']=$arr->bill_date;
            $result['bill_rate']=$arr->bill_rate;            
            $result['tot_amt']=$arr->tot_amt;                  
            $result['status']=$arr->status;
            $result['remarks']=$arr->remarks;
            $result['bill_rate_issue']=$arr->bill_rate_issue; 
            $result['id']=$arr->id;

            
        }else{
            $result['yarn_vendor_id']="";
            $result['bill_firm_id']="";
            $result['yarn_po_id']="";
            $result['bill_no']="";
            $result['bill_date']="";
            $result['bill_rate']="";            
            $result['tot_amt']="";                  
            $result['status']="";
            $result['remarks']="";
            $result['bill_rate_issue']=""; 
            $result['id']="";
        }
        $result['getVendors'] = DB::table('yarn_vendor')->leftJoin('yarn_po', 'yarn_vendor.id', '=', 'yarn_po.yarn_vendor_id')->select('yarn_vendor.*')->where('yarn_vendor.is_deleted', 0)->where('yarn_vendor.status', 1)->get();

        return view('admin.yarn_bill.manage_bill',$result);
    }

    public function getYarnPO(Request $request)
    {
        $id=$request->post('id');
        $pid=$request->post('pid');
        $fid=$request->post('fid');

        $yarns = DB::table('yarn_po')
        ->leftJoin('yarn_vendor', 'yarn_vendor.id', '=', 'yarn_po.yarn_vendor_id')
        ->select(
            'yarn_po.*'
        )
        ->where('yarn_po.yarn_vendor_id', $id)->where('yarn_po.is_deleted', 0)->where('yarn_po.status', 1)->get();
        
        $html='<option value="" >--Select--</option>';
        foreach($yarns as $y){
            $select="";
            if($pid==$y->id){
                $select="selected";
            }
            $html.='<option value="'.$y->id.'" '.$select.' data-id="'.$y->po_number.'">'.$y->po_number.'</option>';
        }

        $firms = DB::table('yarn_vendor')
        ->leftJoin('yarn_vendor_firms', 'yarn_vendor.id', '=', 'yarn_vendor_firms.yarn_vendor_id')
        ->select(
            'yarn_vendor_firms.*'
        )
        ->where('yarn_vendor.id', $id)->where('yarn_vendor.is_deleted', 0)->where('yarn_vendor.status', 1)->get();
        

        $firm='<option value="" >--Select--</option>';
        foreach($firms as $f){
            $select="";
            if($fid==$f->id){
                $select="selected";
            }
            $firm.='<option value="'.$f->id.'" '.$select.' >'.$f->vendor_name.'</option>';
        }

        echo json_encode(array('status'=>1,'message'=>'Data','data'=>$html,'firm'=>$firm));

    }

    public function getChallanDetails(Request $request)
    {
        $id=$request->post('id');
        if($id){
        $result['bill_id']=$request->post('bill_id');
        $result['challan_ids']=DB::table('yarn_bill')->where('id', $request->post('bill_id'))->first();
        
        $result['challan']=DB::table('yarn_inward')
        ->leftJoin('yarn_vendor_firms', 'yarn_vendor_firms.id', '=', 'yarn_inward.challan_id')
        ->leftJoin('yarn_inward_detail', 'yarn_inward_detail.yarn_inward_id', '=', 'yarn_inward.id')
        ->select(
            'yarn_inward.*',
            'yarn_vendor_firms.vendor_name',
            DB::raw('SUM(yarn_inward_detail.inward_qty) as totqty')
        )
        ->where('yarn_inward.yarn_po_id', $id)->where('yarn_inward.is_deleted',0)
        ->groupBy('yarn_inward.id')
        ->get();

        $result['po']=DB::table('yarn_po')
        ->leftJoin('yarn_product', 'yarn_product.id', '=', 'yarn_po.yarn_product_id')
        ->select(
            'yarn_po.*',
            'yarn_product.skt_yarn_name'
        )
        ->where('yarn_po.id', $id)->where('yarn_po.is_deleted',0)->first();
        
        $totqty=0;
        foreach($result['challan'] as $item){
            $totqty=$totqty+$item->totqty;
        }

        
        $html = view('admin.yarn_bill.ajax')->with($result)->render();

        echo json_encode(array('status'=>1,'message'=>'Data','data'=>$html,'totqty'=>$totqty));
        }else{
            echo json_encode(array('status'=>1,'message'=>'Data','data'=>'No Challan Found'));
        }

    }



    public function manage_bill_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bill_firm_id' => 'required'
        ], [
            'bill_firm_id.required' => 'The yarn Bill name is required.'
        ]);
        
        if ($validator->fails()) {
            echo json_encode(['status' => 0, 'message' => $validator->errors()->first()]);
            return;
        }

        //try {
        
            if ($request->post('id') > 0) {
                $model = YarnBill::find($request->post('id'));
                $model->updated_by = session('ADMIN_ID');
                $model->updated_at = date('Y-m-d H:i:s');
                $msg = "Yarn Bill updated";
            } else {
                $model = new YarnBill();
                $model->created_by = session('ADMIN_ID');
                $model->created_at = date('Y-m-d H:i:s');
                $msg = "Yarn Bill inserted";
            }
            $model->yarn_po_id = $request->post('po_no');
            $model->po_inward_no = $request->post('yarn_po_no');             
            $model->challan_ids = (string) implode(',',$request->post('inward_id')); 
            $model->bill_firm_id = $request->post('bill_firm_id');
            $model->bill_no = $request->post('bill_no'); 
            $model->bill_date = $request->post('bill_date'); 
            $model->bill_rate = $request->post('bill_rate'); 
            $model->tot_amt = $request->post('tot_amt');    
            $model->status = $request->post('status'); 
            $model->remarks = $request->post('remarks');
            $model->bill_rate_issue = $request->post('bill_rate_issue');
            $model->save();
            
            echo json_encode(['status' => 1, 'message' => $msg]);

        // } catch (\Exception $e) {
        //     return response()->json(['status' => 0, 'message' => 'Some Error Occurred...']);
        // }
    }



    public function delete(Request $request){

       $id = $request->post('id');
       
       $model=YarnBill::find($id);
       $model->is_deleted='1';
       $model->save();


       echo json_encode(array('status'=>1,'message'=>'Data'));
    } 

    
}

?>