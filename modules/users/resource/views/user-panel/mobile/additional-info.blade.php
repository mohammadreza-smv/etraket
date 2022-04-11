@extends('front-theme::layouts.mobile.user-panel')

@section('panel-content')

    <?php
         $args=['title'=>'اطلاعات شخصی'];
    ?>
    <x-user-panel-box :args="$args">

        <div class="profile_item_list" style="margin:0px 8px !important;">

            @foreach($personal_user_detail as  $detail)
                <?php
                      $editValue=$detail['value'];
                      if(array_key_exists("value2",$detail))
                      {
                          $editValue=$detail['value2'];
                      }
                ?>
                <div>

                    <div class="profile_item_header">

                        <div>
                            {{ $detail['title'] }}
                            <span class="profile-detail-value"> {{ $detail['value'] }}</span>
                        </div>
                        <div onclick="vm.$root.$emit('edit_user_{{ $detail['attr'] }}','{{ $editValue}}')">                            <v-icon>mdi-chevron-left</v-icon>
                        </div>

                    </div>

                </div>

            @endforeach


        </div>

        <user-edit-name></user-edit-name>

        <user-edit-mobile></user-edit-mobile>

        <user-edit-bank_card_number></user-edit-bank_card_number>

        <user-national_identity_number></user-national_identity_number>

        <user-edit-email></user-edit-email>

        <date-of-birth></date-of-birth>
    </x-user-panel-box>

@endsection
