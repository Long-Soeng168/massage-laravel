@extends('admin.layouts.admin')
@section('content')
    <div>
        {{-- <x-page-header :value="__('Purchases')" /> --}}
        @livewire('adjustment-items-table-data')
    </div>
@endsection
