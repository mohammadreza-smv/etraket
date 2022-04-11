<?php
    $args=['title'=>'اطلاعات حساب کاربری'];
    $j=0;
?>
<x-user-panel-box :args="$args">

    <register-detail>

        <table class="table table-bordered user-detail-table">
            @for($i=0;$i<ceil(sizeof($personal_user_detail)/2);$i++)
                <tr>
                    <td @if(!array_key_exists(($j+1),$personal_user_detail)) colspan="2" style="text-align: center" @endif>

                        <?php
                            $editValue=$personal_user_detail[$j]['value'];
                            if(array_key_exists("value2",$personal_user_detail[$j]))
                            {
                                $editValue=$personal_user_detail[$j]['value2'];
                            }
                        ?>
                        <a>
                           <div>
                               {{ $personal_user_detail[$j]['title'] }}
                               <span> {{ $personal_user_detail[$j]['value'] }}</span>
                           </div>
                           <div onclick="vm.$root.$emit('edit_user_{{ $personal_user_detail[$j]['attr'] }}',
                               '{{ $editValue }}')">
                               <v-icon>mdi-circle-edit-outline</v-icon>
                           </div>
                       </a>
                    </td>
                    <?php $j++ ?>
                    @if(array_key_exists($j,$personal_user_detail))
                        <td>
                            <?php
                                 $editValue=$personal_user_detail[$j]['value'];
                                 if(array_key_exists("value2",$personal_user_detail[$j]))
                                 {
                                     $editValue=$personal_user_detail[$j]['value2'];
                                 }
                            ?>
                            <a>
                                <div>
                                    {{ $personal_user_detail[$j]['title'] }}
                                    <span> {{ $personal_user_detail[$j]['value'] }}</span>
                                </div>
                                <div onclick="vm.$root.$emit('edit_user_{{ $personal_user_detail[$j]['attr'] }}','{{ $editValue}}')">
                                   <v-icon>mdi-circle-edit-outline</v-icon>
                                </div>
                            </a>
                        </td>
                        <?php $j++ ?>
                    @endif

                </tr>
            @endfor

        </table>

    </register-detail>


    <user-edit-name></user-edit-name>

    <user-edit-mobile></user-edit-mobile>

    <user-edit-bank_card_number></user-edit-bank_card_number>

    <user-national_identity_number></user-national_identity_number>

    <user-edit-email></user-edit-email>

    <date-of-birth></date-of-birth>

</x-user-panel-box>
