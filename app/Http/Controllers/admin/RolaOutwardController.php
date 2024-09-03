<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\YarnInward;
use App\Models\RolaOutward;
use App\Models\YarnInwardDetail;
use App\Models\YarnPoDetail;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use Storage;

class RolaOutwardController extends Controller
{

    public function index()
    {
        $result['rola']=DB::table('rola_outward')
        ->leftJoin('yarn_vendor', 'rola_outward.yarn_vendor_id', '=', 'yarn_vendor.id')
        ->select(
            'rola_outward.*',
            'yarn_vendor.name',
        )
        ->get();

        return view('admin.rola_outward.index',$result);
    }



    public function manage_rolaoutward(Request $request,$id='')
    {
    
        if($id>0){
            $arr=DB::table('rola_outward')
            ->leftJoin('yarn_vendor', 'rola_outward.yarn_vendor_id', '=', 'yarn_vendor.id')
            ->select(
                'rola_outward.*',
                'yarn_vendor.name',
            )
            ->where(['rola_outward.id'=>$id])->first(); 
            
            $result['yarn_vendor_id']=$arr->yarn_vendor_id;
            $result['challan_no']=$arr->challan_no;
            $result['challan_date']=$arr->challan_date;           
            $result['qty']=$arr->qty;      
            $result['remarks']=$arr->remarks;
            $result['id']=$arr->id;

            
        }else{
            $result['yarn_vendor_id']="";
            $result['challan_no']="";
            $result['challan_date']="";
            $result['qty']="";    
            $result['remarks']="";
            $result['id']="0";
        }
        $result['getVendors'] = DB::table('yarn_vendor')->select('yarn_vendor.*')->where('yarn_vendor.is_deleted', 0)->where('yarn_vendor.status', 1)->get();

        return view('admin.rola_outward.manage_rola',$result);
    }

  

    public function manage_rolaoutward_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'yarn_vendor_id' => 'required'
        ], [
            'yarn_vendor_id.required' => 'The Vendor name is required.'
        ]);
        
        if ($validator->fails()) {
            echo json_encode(['status' => 0, 'message' => $validator->errors()->first()]);
            return;
        }

        try {
        
            if ($request->post('id') > 0) {
                $model = RolaOutward::find($request->post('id'));
                $model->updated_by = session('ADMIN_ID');
                $model->updated_at = date('Y-m-d H:i:s');
                $msg = "Rola updated";
            } else {
                $model = new RolaOutward();
                $model->created_by = session('ADMIN_ID');
                $model->created_at = date('Y-m-d H:i:s');
                $msg = "Rola inserted";
            }
            $model->yarn_vendor_id = $request->post('yarn_vendor_id');
            $model->challan_no = $request->post('challan_no');
            $model->challan_date = $request->post('challan_date');             
            $model->qty = $request->post('qty');    
            $model->remarks = $request->post('remarks');
            $model->save();
            
            echo json_encode(['status' => 1, 'message' => $msg]);

        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Some Error Occurred...']);
        }
    }



    public function delete(Request $request){

       $id = $request->post('id');
       
       $model=RolaOutward::find($id);
       $model->is_deleted='1';
       $model->save();


       echo json_encode(array('status'=>1,'message'=>'Data'));
    } 

    public function getStock()
    {
        $inwardQuery = DB::table('rola_inward')
            ->select('yarn_vendor_id', DB::raw('SUM(qty) as inward_qty'))
            ->groupBy('yarn_vendor_id');

        $outwardQuery = DB::table('rola_outward')
            ->select('yarn_vendor_id', DB::raw('SUM(qty) as outward_qty'))
            ->groupBy('yarn_vendor_id');

        $result['rola'] = DB::table(DB::raw("({$inwardQuery->toSql()}) as inward"))
            ->mergeBindings($inwardQuery) // Merge bindings for the subquery
            ->leftJoin(DB::raw("({$outwardQuery->toSql()}) as outward"), 'inward.yarn_vendor_id', '=', 'outward.yarn_vendor_id')
            ->leftJoin('yarn_vendor', 'inward.yarn_vendor_id', '=', 'yarn_vendor.id')
            ->select(
                'inward.yarn_vendor_id',
                'yarn_vendor.name',
                DB::raw('COALESCE(inward.inward_qty, 0) - COALESCE(outward.outward_qty, 0) AS stock')
            )
            ->get();

        return view('admin.rola_outward.stock',$result);
    }
    public function getStockDetail(Request $request,$id='')
    {

        $result['outward']=DB::table('rola_outward')
            ->leftJoin('yarn_vendor', 'rola_outward.yarn_vendor_id', '=', 'yarn_vendor.id')
            ->select(
                'rola_outward.*',
                'yarn_vendor.name',
            )
            ->where(['rola_outward.yarn_vendor_id'=>$id])->get(); 

        $result['inward']=DB::table('rola_inward')
            ->leftJoin('yarn_vendor', 'rola_inward.yarn_vendor_id', '=', 'yarn_vendor.id')
            ->select(
                'rola_inward.*',
                'yarn_vendor.name',
            )
            ->where(['rola_inward.yarn_vendor_id'=>$id])->get();     
        
        return view('admin.rola_outward.stockdetails',$result);
    }
    
}

?>