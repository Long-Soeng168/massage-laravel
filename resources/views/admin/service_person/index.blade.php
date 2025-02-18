@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Service Person')" />
        @livewire('service-person-table-data')
    </div>
@endsection
