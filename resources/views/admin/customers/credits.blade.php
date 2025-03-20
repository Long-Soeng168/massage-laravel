@extends('admin.layouts.admin')
@section('content')
    <div>
        {{-- <x-page-header :value="__('Purchases')" /> --}}
        @livewire('customer-credit-table-data')
    </div>
@endsection
