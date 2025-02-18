@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    @livewire('package-show', [
        'id' => $id
    ])
</div>

@endsection
