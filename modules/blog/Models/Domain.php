<?php

namespace Modules\blog\Models;

class Domain
{
    public function addConfig($request)
    {
        $config=[];
        $data=$request->all();
        foreach($data as $key=>$value)
        {
            if($key!="_token")
            {
                if(!empty($value))
                {
                    $config[$key]=$value;
                }
            }
        }

        $text='<?php

return  '.var_export($config,true).';';

        file_put_contents(config_path('blog.php'),$text);
    }
}
