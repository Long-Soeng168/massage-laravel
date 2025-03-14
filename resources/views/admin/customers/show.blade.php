@extends('admin.layouts.admin')

@section('content')
    <div class="p-4">
        @livewire('customer-show', [
            'id' => $id,
        ])
    </div>
@endsection
