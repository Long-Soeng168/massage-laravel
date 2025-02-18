@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Adjustment Credit')" />
        @livewire('adjust_credits')
    </div>
@endsection
