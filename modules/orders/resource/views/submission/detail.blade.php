<?php
$get_submission_detail=get_submission_detail($value);
$j=0;
?>
<table class="table table-bordered order_table_info">


    @for($i=0;$i<ceil(sizeof($get_submission_detail)/2);$i++)
        <tr>
            <td @if(!array_key_exists(($j+1),$get_submission_detail)) colspan="2" style="text-align: center" @endif>
                {{ $get_submission_detail[$j]['label'] }}
                <span> {{ $get_submission_detail[$j]['value'] }}</span>
            </td>
            <?php $j++ ?>
            @if(array_key_exists($j,$get_submission_detail))
                <td>
                    {{ $get_submission_detail[$j]['label'] }}
                    <span> {{ $get_submission_detail[$j]['value'] }}</span>
                </td>
                <?php $j++ ?>
            @endif

        </tr>
    @endfor

</table>
