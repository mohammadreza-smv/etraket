@if(Session::has('warring'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">

        {{ Session::get('warring') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
