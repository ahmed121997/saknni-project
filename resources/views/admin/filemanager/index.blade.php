@extends('admin.layouts.app')
@section('title', ' | File Manager')
@section('content')
    <div class="container-fluid">
        <iframe src="/admin/media-filemanager" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
    </div>
@endsection
