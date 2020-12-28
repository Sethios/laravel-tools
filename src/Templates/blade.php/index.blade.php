@extends('layouts.app')

@section('content-header')
    {{ trans('¤_model¤.index_plural') }}
@endsection

@section('content')
    @can('import ¤_model¤_csv|download ¤_model¤_csv')
        @component('components.import')
            @slot('route', "¤_model¤.importSave")
            @slot('model', "¤_model¤")
            @slot('download', true)
        @endcomponent
    @endcan

    <div class="box-body">
        <table id="¤-model¤-table" class="table display" style="width:100%">
            <thead>
                <tr>
                    <th class="no-sort" data-filter="search">{{ trans('¤_model¤.name') }}</th>
                    <th class="no-sort" data-filter="no-sort">{{ trans('¤_model¤.actions') }}</th>
                </tr>
            </thead>
            {{-- <tbody>
                @foreach ($¤modelsC¤ as $¤modelC¤)
                    @include('¤modelC¤.partials.¤modelC¤ListItem')
                @endforeach
            </tbody> --}}
        </table>
    </div>
    @component('components.modal')
        @slot('title', trans('¤_model¤.delete'))
        @slot('id', 'delete¤ModelP¤Modal')
        @slot('class', "¤-model¤-delete-modal")
        @slot('content')
            <p id="¤-model¤-question" data-row="0" data-id="0">{{ trans('app.modal.delete_question') }}</p>
        @endslot
    @endcomponent
@endsection

@push('scripts')
    <script type="text/javascript">
        jQuery(function ($) {
            $(document).ready(function() {
                ¤_model¤_setings = {
                    ajax: route('¤_model¤.index'),
                    columns: [
                        { 'data': 'name' },
                        { 'data': 'actions'},
                        //
                    ],
                };
                DropTableSearch('#¤-model¤-table', ¤_model¤_setings);
            });
        });
    </script>
@endpush