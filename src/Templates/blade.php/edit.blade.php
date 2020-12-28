@extends('layouts.app')

@section('content-header')
    {{ trans('¤_model¤.edit') }}
@endsection

@section('content')
    <div class="form-wrapper">
        @include('¤modelC¤.partials.form', ['action' => 'edit', 'method' => 'patch', 'route' => '¤_model¤.update'])
    </div>
@endsection

@push('scripts')

@endpush