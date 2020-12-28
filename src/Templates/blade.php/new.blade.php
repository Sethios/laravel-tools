@extends('layouts.app')

@section('content-header')
    {{ trans('¤_model¤.index') }}
@endsection

@section('content')
    <div class="form-wrapper">
        @include('¤modelC¤.partials.form', ['action' => 'new', 'method' => 'put', 'route' => '¤_model¤.store'])
    </div>
@endsection

@push('scripts')

@endpush