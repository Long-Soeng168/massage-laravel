@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    @livewire('service-edit', [
        'id' => $id
    ])
</div>

@endsection
