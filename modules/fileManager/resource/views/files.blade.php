@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
           ['title'=>'مدیریت فایل ها','url'=>url('admin/filemanager')]
        ]])

        <file-manager dir="files"></file-manager>

    </div>

@endsection

