<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserGroup;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use Storage;

class UserController extends Controller
{

    public function index()
    {
        $result['users']=User::where('is_deleted','0')->where('id','!=' ,'1')->orderBy('id', 'DESC')->get();

        return view('admin.user.user',$result);
    }

    public function manage_user(Request $request,$id='')
    {
        if($id>0){
            $arr=User::where(['id'=>$id])->first(); 

            $result['name']=$arr->name;
            $result['phone']=$arr->phone;
            $result['email']=$arr->email;
            $result['address']=$arr->address;
            $result['password']=$arr->password;
            $result['user_images']=$arr->user_image;
            $result['status']=$arr->status;
          
            $result['id']=$arr->id;

            $getgroups = UserGroup::where('user_id', $id)->first();
            $result['groupid'] = $getgroups->group_id;
           
        }else{
            $result['name']='';
            $result['phone']='';
            $result['email']='';
            $result['address']='';
            $result['password']="";
            $result['user_images']=
            $result['status']="";
            
            $result['id']=0;

            $result['groupid'] = '';
        }

        $result['designations']=DB::table('groups')->where('id','!=' ,'1')->get();
       
        return view('admin.user.manage_user',$result);
    }

    public function manage_user_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'group_id' => 'required',
            'user_image' => "mimes:jpeg,jpg,png"
        ], [
            'name.required' => 'The name is required.',
            'phone.required' => 'The phone number is required.',
            'group_id.required' => 'The designation is required.'
        ]);
        
        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->first());
            return redirect()->back();
        }        

        if($request->post('id')>0){
            $model=User::find($request->post('id'));
            $model->updated_by = session('ADMIN_ID');
            $model->updated_at=date('Y-m-d H:i:s');
            $msg="User updated";

        }else{
            $model=new User();
            $model->created_by = session('ADMIN_ID');
            $model->created_at=date('Y-m-d H:i:s');
            $msg="User inserted";
        }

        if ($request->hasFile('user_image')) {
            // Handle image file upload
            $imageFile = $request->file('user_image');
            $imageFileName = time() . '.' . $imageFile->getClientOriginalExtension();

            // Specify the directory where you want to save the image
            $imageDirectory = public_path('user_image');

            // Move the uploaded file to the specified directory
            $imageFile->move($imageDirectory, $imageFileName);


            $model->user_image = $imageFileName;
        }

        if ($request->filled('password')) {
            $model->password = Hash::make($request->post('password'));
        }
        
        $model->name=$request->post('name');
        $model->phone=$request->post('phone'); 
        $model->email=$request->post('email');
        $model->address=$request->post('address');  
        $model->status=$request->post('status'); 
       
        $model->save();
        
        if ($request->post('group_id')) {
            UserGroup::where('user_id', $request->post('id'))->delete();
                UserGroup::create([
                    'user_id' => $model->id,
                    'group_id' => $request->post('group_id'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            
        }
        
        $request->session()->flash('message',$msg);
        return redirect()->route('admin.user');
        
    }

    public function checkPhone(Request $request)
    {
        $phone = $request->input('phone');

        // Perform your logic to check if the phone number exists
        $user = User::where('phone', $phone)->where('is_deleted','0')->exists();

        // Return JSON response based on the existence of the phone number
        return response()->json(['status' => $user ? '1' : '0']);
    }

    public function delete(Request $request){
       $id = $request->post('id');
       $model=User::find($id);
       $model->is_deleted='1';
       $model->save();

       UserGroup::where('user_id',$id)->delete();
       
       echo json_encode(array('status'=>1,'message'=>'Data'));
    } 

    public function filter(Request $request)
    {
        $status = $request->get('status', '');
        $branch = $request->get('branch', '');

        $query = DB::table('users')
                    ->leftJoin('users_branch as branch', 'branch.user_id', '=', 'users.id')
                    ->where('users.is_deleted', '0')->where('users.id','!=' ,'1');

        if ($status) {
            $query->where('users.status', $status);
        }

        if ($branch) {
            $query->where('branch.mst_ebranch_id', $branch);
        }

        $users = $query->select(
                    'users.*'
                )
                ->orderBy('users.id', 'DESC')
                ->get();

        $returnHTML = view('admin.user.filter')->with(['users' => $users])->render();
        return response()->json(['status' => 1, 'message' => 'Data', 'html' => $returnHTML]);
    }

    
}

?>