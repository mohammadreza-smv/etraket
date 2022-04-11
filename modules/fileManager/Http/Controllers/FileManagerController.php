<?php


namespace Modules\fileManager\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\fileManager\Http\Request\UploadRequest;

class FileManagerController extends Controller
{
    public function filemanager()
    {
        return CView('fileManager::files');
    }

    public function dirList($path)
    {
        $list=scandir($path);
        $array=[];
        foreach ($list as $key=>$value)
        {
            if(is_dir($path.'/'.$value) && $value!='.' && $value!='..')
            {
                $array[]=$value;
            }
        }
        return $array;
    }

    public function fileList(Request $request){
        $path=$request->get('path');
        $list=scandir($path);
        return $list;
    }

    public function upload(UploadRequest $request){

        $dir=$request->get('dir');
        if($request->hasFile('file')){
            $file_name=time().'.'.$request->file('file')->getClientOriginalExtension();
            if($request->file('file')->move($dir,$file_name))
            {
                return  [
                    'status'=>'success',
                    'fileName'=>$file_name
                ];
            }
            else{
                return  [
                    'status'=>'error',
                ];
            }
        }
        else{
            return  [
                'status'=>'error',
            ];
        }
    }

    public function removeFile(Request $request){
        $path=$request->get('path');
        if(file_exists($path)){
            unlink($path);
            return 'ok';
        }
        else{
            return  'error';
        }
    }
}
