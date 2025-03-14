@extends('admin.layouts.admin')

@section('content')
    <div class="p-4">
        @livewire('customer-invoice', [
            'id' => $id,
        ])
    </div>
@endsection
