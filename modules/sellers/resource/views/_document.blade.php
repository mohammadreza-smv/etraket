<table class="table table-bordered table-striped" style="margin-top:20px">
    <thead>
    <tr>
        <th>ردیف</th>
        <th>عنوان</th>
        <th>تصویر</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php $i=0;?>
    @if(!empty($document->shenasname))
        <?php $i++; ?>
        <tr>
            <td>{{ replace_number($i) }}</td>
            <td style="width:250px">اسکن صفحه اصلی شناسنامه</td>
            <td>
                <img src="{{ url('files/seller/'.$document->shenasname) }}" style="max-width:30%;">
            </td>
            <td>
                <a href="{{ url('files/seller/'.$document->shenasname) }}" target="_blank">
                    <span class="fa fa-eye"></span>
                </a>
            </td>
        </tr>
    @endif

    @if(!empty($document->cart))
        <?php $i++; ?>
        <tr>
            <td>{{ replace_number($i) }}</td>
            <td>اسکن کارت ملی</td>
            <td>
                <img src="{{ url('files/seller/'.$document->cart) }}" style="max-width:30%;">
            </td>
            <td>
                <a href="{{ url('files/seller/'.$document->cart) }}" target="_blank">
                    <span class="fa fa-eye"></span>
                </a>
            </td>
        </tr>
    @endif

    @if(!empty($document->rooznamepic))
        <?php $i++; ?>
        <tr>
            <td>{{ replace_number($i) }}</td>
            <td>اسکن روزنامه ثبت شرکت</td>
            <td>
                <img src="{{ url('files/seller/'.$document->rooznamepic) }}" style="max-width:30%;">
            </td>
            <td>
                <a href="{{ url('files/seller/'.$document->rooznamepic) }}" target="_blank">
                    <span class="fa fa-eye"></span>
                </a>
            </td>
        </tr>
    @endif
    </tbody>
</table>
