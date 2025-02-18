@extends('admin.layouts.admin')

@section('content')
<div class="px-4">
    <x-page-header :value="__('Package Create')" />
    @livewire('package-create')
</div>

@endsection
