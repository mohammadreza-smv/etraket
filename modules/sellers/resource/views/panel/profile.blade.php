@extends('sellers::layouts.panel')

@section('content')

    <div>

        <?php
            $args=['title'=>'ویرایش پروفایل'];
        ?>

        <x-seller-panel-box :args="$args">
             <seller-profile>

                  <template v-slot:step1>

                      <?php
                             $option=['url' =>url('sellers/panel/profile')];
                             $form=new \App\Lib\FormBuilder(null,$option,'edit',$seller);
                      ?>

                      <?php $form->textInput('fname','نام',['validate'=>'required']);  ?>

                      <?php $form->textInput('lname','نام خانوادگی',['validate'=>'required']);  ?>

                      <?php $form->textInput('brand_name','نام فروشگاه',['validate'=>'required']);  ?>

                      <?php $form->textInput('email','ایمیل',['validate'=>'required']);  ?>

                      <?php $form->textInput('mobile','شماره موبایل',['validate'=>'required']);  ?>

                      <?php $form->textInput('password','کلمه عبور',['type'=>'password']);  ?>

                      <?php $form->textInput('shaba','شماره شبا',[]);  ?>

                      <div class="profile_location">
                          <register-location province_id="{{ $seller->province_id }}"
                                             city_id="{{ $seller->city_id }}"
                          ></register-location>
                      </div>

                      @if($seller->account_status==='reject')

                          <?php $form->imageInput('','اسکن صفحه اصلی شناسنامه',['validate'=>'required']);  ?>

                          <?php $form->imageInput('','اسکن کارت ملی',['validate'=>'required']);  ?>

                     @endif

                      <?php $form->textarea('description','توضیحات فروشگاه',['class'=>'total-width']);  ?>


                      <?php $form->btn('ثبت','edit');  ?>

                      <?php $form->close();  ?>

                  </template>

             </seller-profile>
        </x-seller-panel-box>
    </div>

@endsection
