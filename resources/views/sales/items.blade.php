@extends('admin.layouts.admin')
@section('content')
    <div>
        {{-- <x-page-header :value="__('Purchases')" /> --}}
        @livewire('sale-items-table-data')
    </div>
@endsection
