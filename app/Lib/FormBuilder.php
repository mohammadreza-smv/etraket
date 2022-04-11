<?php

namespace App\Lib;
use Form;
use Config;
use Request;
use Session;
class FormBuilder
{
    protected $errors=null;

    protected $routeName=null;

    protected $otherField=[];

    public static $cleave_input=[];

    public static $date_input=[];

    protected $defined_vars;

    protected $data=null;

    protected $formId;

    public function __construct($errors,$arg,$type='create',$data=[],$defined_vars=[])
    {
        $this->defined_vars=$defined_vars;
        $this->errors=$errors;
        $this->formId='form_'.rand(1,100);
        $method=array_key_exists('method',$arg) ? $arg['method'] : 'post';
        $cssClass=array_key_exists('class',$arg) ? $arg['class'] : '';

        if($type=='create'){
           if(array_key_exists('query_string',$arg)){
               $arg['url']=$arg['url'].$arg['query_string'];
               unset($arg['query_string']);
           }
        }
        else{
           $this->data=$data;
           $arg['url']=$arg['url'].'/'.$data->id;
           if(array_key_exists('query_string',$arg)){
               $arg['url']=$arg['url'].$arg['query_string'];
               unset($arg['query_string']);
           }
        }
        $request_url=url($arg['url']);
        echo "<form-component form_id='$this->formId' method='$method' request_url='$request_url' css_class='$cssClass' type='$type'>";
        $this->routeName=Request::route() ? Request::route()->getName() : null;
        $this->getOtherField();
    }

    public function textInput($name,$label,$args,$value=null){
       $this->checkHasField('before_'.$name);
       if($value==null){
           $value=($this->data!=null) ? $this->data[$name] : '';
       }
       if(array_key_exists('type',$args) && $args['type']=='password'){
           $value='';
       }
       $prepend_icon=array_key_exists('prepend_icon',$args) ? $args['prepend_icon'] : '';
       $args=json_encode($args);
       echo "<text-input label='$label' name='$name' :args='$args' value='$value' prepend_icon='$prepend_icon'></text-input>";
       $this->checkHasField('after_'.$name);
    }

    public function colorInput($name,$label,$args,$value=null){
        $this->checkHasField('before_'.$name);
        $args=json_encode($args);
        if($value==null){
            $value=($this->data!=null) ? $this->data[$name] : '';
        }
        echo "<color-input label='$label' name='$name' :args='$args' value='$value'></color-input>";
        $this->checkHasField('after_'.$name);
    }

    public function fileInput($name,$label,$args=[]){
        $value=($this->data!=null) ? $this->data[$name] : '';
        echo "<file-input label='$label' value='$value' name='$name'></file-input>";
    }

    public function imageInput($name,$label,$args=[],$default=''){
        $args=json_encode($args);
        echo "<image-select-box label='$label' name='$name' default='$default' :args='$args'></image-select-box>";
    }

    public function editor($name,$args,$value=null){
        if($value==null){
            $value=($this->data!=null) ? $this->data[$name] : '';
        }
        echo "<text-editor name='$name' value='$value'></text-editor>";
    }

    public function tagBox($name,$label,$args,$value=null){
        if($value==null){
            $value=($this->data!=null) ? $this->data[$name] : '';
        }
        $args=json_encode($args);
        echo "<tag-box name='$name' label='$label' value='$value' :args='$args'></tag-box>";
    }

    public function select($list,$name,$label,$args,$value=null){
        $this->checkHasField('before_'.$name);
        $prepend_icon=array_key_exists('prepend_icon',$args) ? $args['prepend_icon'] : '';
        $args=json_encode($args);
        $list=json_encode($list);
        if($value==null){
            $value=($this->data!=null) ? $this->data[$name] : '';
        }
        echo "<combo-box label='$label' name='$name' :args='$args' :list='$list' value='$value' prepend_icon='$prepend_icon'></combo-box>";

        $this->checkHasField('after_'.$name);
    }

    public function checkbox($name,$label,$value=null,$args=[]){
        if($value==null){
            $value=($this->data!=null) ? $this->data[$name] : '';
        }
        echo "<check-box label='$label' value='$value' name='$name'></check-box>";
    }

    public function numberInput($name,$label=null,$args=[],$value=null){
        $this->checkHasField('before_'.$name);
        $args=json_encode($args);
        if($value==null){
            $value=($this->data!=null) ? $this->data[$name] : '';
        }
        echo "<text-input label='$label' name='$name' :args='$args' value='$value' input_type='number'></text-input>";
        $this->checkHasField('after_'.$name);
    }

    public function close(){
       echo '</form-component>';
   }

    public function btn($label,$type='create'){
       $formId=$this->formId;
       echo "<form-btn text='$label' type='$type' form_id='$formId' ></form-btn>";
    }

    public function textarea($name,$label,$args,$value=null){
        $this->checkHasField('before_'.$name);
        $args=json_encode($args);
        if($value==null){
            $value=($this->data!=null) ? $this->data[$name] : '';
        }
        echo "<textarea-field label='$label' name='$name' :args='$args' value='$value'></textarea-field>";
        $this->checkHasField('after_'.$name);
    }

    protected function getOtherField(){
       if($this->routeName){
           $routeName=str_replace('.','_',$this->routeName);
           $action=$routeName.'_form';
           $result=run_action($action,[],true);
           if(is_array($result)){
               $this->otherField=$this->otherField+$result;
           }
       }
    }

    protected function checkHasField($event){
        $views=[];
       foreach ($this->otherField as $fields){
           if(is_array($fields)){
               foreach ($fields as $key=>$value){
                   if($key==$event){
                       if(is_array($value)){
                           if(array_key_exists('index',$value)){
                               if(array_key_exists($value['index'],$views)){
                                   $views[]=$views[$value['index']];
                               }
                               $views[$value['index']]=view($value['path'],['form'=>$this]+$value['args']+$this->defined_vars);
                           }
                           else{
                               $views[]=view($value['path'],['form'=>$this]+$value['args']+$this->defined_vars);
                           }
                       }
                       else{
                           $views[]=view($value,['form'=>$this]+$this->defined_vars);
                       }
                   }
               }
           }
       }
       if(sizeof($views)>0){
           ksort($views);
           foreach ($views as $view){
               echo $view;
           }
       }
    }

    public function fieldLocation($action){
        $result=run_action($action,[],true);
        if(is_array($result)){
            foreach ($result as $path){
                echo view($path,['form'=>$this]);
            }
        }
    }

    public function dateInput($name,$label=null,$args=[],$value=null){

        $this->checkHasField('before_'.$name);
        $args=json_encode($args);
        if($value==null){
            $value=($this->data!=null) ? $this->data[$name] : '';
        }
        echo "<date-input label='$label' name='$name' :args='$args' value='$value' ></date-input>";
        $this->checkHasField('after_'.$name);
    }
}
