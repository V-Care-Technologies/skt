<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserGroup;
use App\Models\User;
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
                            ->first();

                $request->session()->put('ADMIN_LOGIN',true);
                $request->session()->put('ADMIN_ID',$result->id);
                $request->session()->put('ADMIN_GROUP_ID', $getgroup->group_id);
                $request->session()->put('ADMIN_GROUP_NAME', $getgroup->group_name);

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

        $databaseName = "skt";
        $username = "root";
        $password = "";
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
        return view('admin.dashboard');
    }

}
