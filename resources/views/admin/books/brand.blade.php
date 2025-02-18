@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Brands')" />
        @livewire('book-brand-table-data')
    </div>
@endsection
