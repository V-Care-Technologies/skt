<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserGroup;
use App\Models\User;
use App\Models\UserBranch;
use App\Models\MstMaster;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;
use DB;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->session()->has('ADMIN_LOGIN')){
            return redirect('admin/dashboard');
        }else{
            return view('admin.login');
        }
        return view('admin.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function auth(Request $request)
    {
        $phone=$request->post('phone');
        $password=$request->post('password');

        $result=User::where(['phone'=>$phone])->where('status','1')->where('is_deleted','0')->first();
        if($result){
            if(Hash::check($request->post('password'),$result->password)){
                $getgroup = UserGroup::select(
                                'user_groups.*', 
                                'groups.description as group_name'
                            )
                            ->leftJoin('groups', 'user_groups.group_id', '=', 'groups.id')
                            ->where('user_groups.user_id', $result->id)
                            ->get();

                $groupIds = $getgroup->pluck('group_id')->toArray();
                $groupNames = $getgroup->pluck('group_name')->toArray();
                
                $request->session()->put('ADMIN_LOGIN',true);
                $request->session()->put('ADMIN_ID',$result->id);
                $request->session()->put('ADMIN_GROUP_IDS', $groupIds);
                $request->session()->put('ADMIN_GROUP_NAMES', $groupNames);

                return redirect('admin/dashboard')->with('message','Login Successfully');
            }else{
                // $request->session()->flash('error','Please enter correct password');
                return redirect('admin/login')->with('error','Please enter correct password');
            }
        }else{
            // $request->session()->flash('error','Please enter valid login details');
            return redirect('admin/login')->with('error','Please enter valid login details');
        }
    }

    public function backup()
    {
        // Define the backup directory and filename
        $backupDirectory = storage_path('app/backups');
        $backupFileName = 'backup-on-' . now()->format('Y-m-d-H-i-s') . '.sql';
        
        // Ensure the backup directory exists
        if (!is_dir($backupDirectory)) {
            mkdir($backupDirectory, 0755, true);
        }
        
        // Path to store the SQL backup
        $backupFilePath = $backupDirectory . '/' . $backupFileName;
        
        // Database credentials
        // $databaseName = env('DB_DATABASE');
        // $username = env('DB_USERNAME');
        // $password = env('DB_PASSWORD');
        // $host = env('DB_HOST', '127.0.0.1');

        $databaseName = "evaluation";
        $username = "root";
        $password = "Vcare123???";
        $host = "127.0.0.1";
        
        // Command to create a backup using mysqldump
        
        $command = "mysqldump -h $host -u $username --password=$password $databaseName > $backupFilePath";

        $process = Process::fromShellCommandline($command);
        $process->run();
        
        // Check if the process was successful
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Create a ZIP archive of the SQL backup
        $zipArchiveName = 'backup-on-' . now()->format('Y-m-d-H-i-s') . '.zip';
        $zipArchivePath = $backupDirectory . '/' . $zipArchiveName;
        
        $zip = new \ZipArchive();
        if ($zip->open($zipArchivePath, \ZipArchive::CREATE) === TRUE) {
            $zip->addFile($backupFilePath, basename($backupFilePath));
            $zip->close();
            
            // Remove the original SQL file
            unlink($backupFilePath);
            
            // Send the ZIP file as a downloadable response
            return response()->download($zipArchivePath)->deleteFileAfterSend(true);
        } else {
            // Handle ZIP creation failure
            return redirect()->back()->with('error', 'Database backup ZIP creation failed.');
        }
    }


    public function dashboard(Request $request)
    {
        $branchId = $request->input('branch_id');
        $teamId = $request->input('team_id');

        $result['branchs']=MstMaster::where('is_deleted','0')->where('types','7')->where('status','1')->get();
        $result['allteams']=User::where('is_deleted','0')->where('id' ,'!=' ,'1')->where('status','1')->get();

        $result['allusers']=User::leftJoin('user_groups', 'user_groups.user_id', '=', 'users.id')
                                ->where('users.is_deleted','0')
                                ->where('users.status','1')
                                ->where('user_groups.group_id','!=' ,'1')
                                ->groupBy('users.id')
                                ->select('users.*')
                                ->get();

        // Getting the current month and year
        $currentMonth = Carbon::now()->format('F'); // Full month name, e.g., "June"
        $currentYear = Carbon::now()->year; // e.g., 2024

        // Counting cases for the current month and year
        $result['caseCount'] = DB::table('mst_case')
                    ->where('is_deleted','0')
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->when($branchId, function ($query, $branchId) {
                        return $query->where('mst_evaluation_branch_id', $branchId);
                    })
                    ->count();

        $result['casesTodayCount'] = DB::table('mst_case')
            ->where('is_deleted','0')
            ->whereDate('created_at', Carbon::today())
            ->when($branchId, function ($query, $branchId) {
                return $query->where('mst_evaluation_branch_id', $branchId);
            })
            ->count();

        $result['queries'] = DB::table('mst_case')
            ->where('is_deleted','0')
            ->where('mst_status_id','28')
            ->when($branchId, function ($query, $branchId) {
                return $query->where('mst_evaluation_branch_id', $branchId);
            })
            ->count();

        $result['highPriority'] = DB::table('mst_case')
            ->where('is_deleted','0')
            ->where('priority', '3')
            ->when($branchId, function ($query, $branchId) {
                return $query->where('mst_evaluation_branch_id', $branchId);
            })
            ->count();

        // $result['teams'] = DB::table('users')
        //     ->where('is_deleted','0')
        //     ->where('id','!=' ,'1')
        //     ->where('status','1')
        //     ->count();
        $result['totreviews'] = DB::table('mst_case')
            ->where('is_deleted','0')
            ->where('mst_status_id','=' ,64)
            ->count();
        

        // Adding to the result array
        $result['currentMonth'] = $currentMonth;
        $result['currentYear'] = $currentYear;

        //For Roundchart 1
        // Fetch status titles and their respective counts from mst_case
        $statuses = DB::table('mst_case')
        ->select('mst_status_id', DB::raw('COUNT(*) as count'))
        ->where('is_deleted','0')
        ->whereYear('mst_case.created_at', '=', $currentYear)
        ->whereMonth('mst_case.created_at', '=', Carbon::now()->month)
        ->when($branchId, function ($query, $branchId) {
            return $query->where('mst_evaluation_branch_id', $branchId);
        })
        ->when($teamId, function ($query, $teamId) {
            return $query->where('assignto_userid', $teamId);
        })
        ->groupBy('mst_status_id')
        ->get();

        // Fetch status titles from mst_master where types = 8
        $statusTitles = DB::table('mst_master')
            ->where('types', 8)
            ->where('is_deleted','0')
            ->pluck('title', 'id');

        // Prepare data for chart
        $chartData = [];
        foreach ($statuses as $status) {
            if (isset($statusTitles[$status->mst_status_id])) {
                $title = $statusTitles[$status->mst_status_id];
                $chartData[] = [
                'title' => $title,
                'count' => $status->count,
                'color' => $this->getStatusColor($title), // Assuming a function to get color based on title
                ];
            }
        }
        $result['chartData'] = $chartData;

        //For Fees Type
        // Get all possible labels from mst_master where types = 2
        $possibleLabels = DB::table('mst_master')
        ->where('types', 2)
        ->pluck('title')
        ->toArray();

        // Fetch data from mst_case table for the current month and year
        $data = DB::table('mst_master')
                ->leftJoin('mst_case', 'mst_master.id', '=', 'mst_case.mst_feestype_id')
                ->where('mst_master.types', 2)
                ->whereYear('mst_case.created_at', '=', $currentYear)
                ->whereMonth('mst_case.created_at', '=', Carbon::now()->month)
                ->when($branchId, function ($query, $branchId) {
                    return $query->where('mst_case.mst_evaluation_branch_id', $branchId);
                })
                ->select('mst_master.title', DB::raw('COALESCE(SUM(mst_case.fees_amt), 0) as total_fees'))
                ->groupBy('mst_master.title')
                ->get();

        // Prepare data for chart
        $result['labels'] = $possibleLabels;
        $totals = [];

        foreach ($possibleLabels as $label) {
            $total = $data->where('title', $label)->first();
            $totals[] = $total ? $total->total_fees : 0;
        }
        $result['totals'] = $totals;

        //For last 3 days record of case
        $threeDaysAgo = Carbon::now()->subDays(3)->format('Y-m-d');

        $cases = DB::table('mst_case')
                        ->leftJoin('mst_master as bank', 'bank.id', '=', 'mst_case.mst_bank_id')
                        ->leftJoin('mst_master as ebranch', 'ebranch.id', '=', 'mst_case.mst_evaluation_branch_id')
                        ->leftJoin('mst_master as status', 'status.id', '=', 'mst_case.mst_status_id')
                        ->where('mst_case.is_deleted', '0')
                        ->whereDate('mst_case.created_at', '>=', $threeDaysAgo)
                        ->when($branchId, function ($query, $branchId) {
                            return $query->where('mst_case.mst_evaluation_branch_id', $branchId);
                        })
                        ->select(
                            'mst_case.*',
                            DB::raw('DATE_FORMAT(mst_case.created_at, "%d-%m-%Y %h:%i:%s %p") AS login_date'),
                            'bank.title as bank_name',
                            'ebranch.title as evaluation_branch_name',
                            'status.title as status'
                        )
                        ->orderBy('mst_case.id', 'DESC')
                        ->get();
                        
        foreach ($cases as $case) {
            if($case->tat == '0'){
                $startDate = Carbon::parse(date('Y-m-d',strtotime($case->created_at)));
                $endDate = Carbon::parse(date('Y-m-d'));
                // Calculate the number of days between the two dates
                $case->tat = $startDate->diffInDays($endDate);
            }
        }
        
        $result['cases'] = $cases;
        
        $result['branchId'] = $branchId;
        $result['teamId'] = $teamId;

        $groupIdss = session('ADMIN_GROUP_IDS', []);
        if (in_array(1, $groupIdss)){
            return view('admin.dashboard',$result);
        }else{
            return view('admin.dashboard1',$result);
        }
       
    }

    public function livetracking(Request $request){
        //$district_id=$request->post('district_id');
        $live_tracking=DB::table('users')->where('live_tracking','1')->get();
        $ar=[];
        foreach($live_tracking as $k=> $live){
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://evaluation-aspects-default-rtdb.firebaseio.com/employee_live_locations/'.$live->id.'.json?auth=nXT4jXWtFyzk5FJrmyALF6Jb4if5xNykzrmPGIdr');
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false);
            $results = curl_exec($ch);
            curl_close($ch);
            //print_r($results);exit;
            $arr=[];
           $data['user'][$k]=$live->name;
           $res=json_decode($results);
           $arr[$k]= array(@$res->longitude,@$res->latitude);
           $data['end'][$k]=json_encode(array(@$res->longitude,@$res->latitude));
           //if(is_array(json_decode($results))){
            
        //    foreach(json_decode($results) as $key => $res){
        //        $arr[$key]= array(@$res->longitude,@$res->latitude);
        //       if($key=='0'){
        //           $data['start'][$k]=json_encode(array(@$res->longitude,@$res->latitude));
        //       }
        //           $data['end'][$k]=json_encode(array(@$res->longitude,@$res->latitude));
        //    }
           $ar[$k]=array(
                   'type'=>  'Feature',
                   'properties'=> array(),
                   'geometry'=>array(
                       'type'=> 'LineString',
                       'coordinates'=>$arr
                   )
                   );
           }
       // }
        if($ar){
        $arrays=[];       
           $arrays=array(
               'type'=>'FeatureCollection',            
               'features'=>$ar
           );
           $data["result"]=json_encode($arrays);
           $html=view('admin.ajaxLive', $data)->render();
           echo json_encode(array('status'=>1,'message'=>'Data','html'=>$html));
           
        }else{
             echo json_encode(array('status'=>0,'message'=>'No Live Data Found','html'=>'' ));
        }
    }


    // Function to get color based on status title
    private function getStatusColor($title)
    {
        // Define colors based on status title (sample colors)
        $colors = [
            'Pending' => '#FFEFE0',
            'Blanks' => '#EBEBEB',
            'Hold' => '#FEF9C3',
            'Withdrawal' => '#ECFDF3',
            'Report Checked' => '#EDF6FF',
            'Visit Done' => '#CCFFFC',
            'Submitted' => '#ECFDF3',
            'Query' => '#FEE2E2',
            'Drafting' => '#EBEBEB',
            'Assign Submit' => '#009fff26',
            'Assign Visit' => '#00800045'
            // Add more colors as needed
        ];

        // Return color based on title, default to a fallback color if not found
        return $colors[$title] ?? '#CCCCCC';
    }

}
