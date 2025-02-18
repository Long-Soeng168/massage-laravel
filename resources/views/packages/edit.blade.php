@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    <x-page-header :value="__('Package Edit')" />
    @livewire('package-edit', [
        'id' => $id
    ])
</div>

@endsection
