@if(sizeof($value->events)>0)
    <div style="margin-top: 20px">
        <p>رویداد های مرسوله</p>
        <table class="table table-bordered event-table" >
            <thead>
            <tr>
                <th>ردیف</th>
                <th>تغییر از وضعیت</th>
                <th>به وضعیت</th>
                <th>زمان تغییر وضعیت</th>
                <th>توسط</th>
            </tr>
            </thead>

            @foreach($value->events as $k=>$event)
                <tr>
                    <td>{{ replace_number(++$k) }}</td>
                    <td>
                        @if(array_key_exists($event->from,$OrderStatus))
                            {{  getOrderStatus($event->from) }}
                        @endif
                    </td>
                    <td>
                        @if(array_key_exists($event->to,$OrderStatus))
                            {{  getOrderStatus($event->to) }}
                        @endif
                    </td>
                    <td>
                        @php
                            $e=explode(' ',$event->created_at);
                            $e2=explode('-',$e[0]);
                        @endphp
                        {{ replace_number($Jdf->gregorian_to_jalali($e2[0],$e2[1],$e2[2],'-')) }}
                    </td>
                    <td>
                        @if($event->user)
                            <a href="{{ url('admin/users/'.$event->user->id) }}" class="router-link" style="color: black;text-decoration:none">
                                {{ $event->user->name }}
                            </a>
                        @endif
                    </td>
                </tr>

                @if(!empty($event->tozihat) && $event->tozihat!=="null")
                    <tr>
                        <td colspan="5" style="text-align: right">
                            <span>توضیحات : </span>
                            {{ $event->tozihat }}
                        </td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
@endif
