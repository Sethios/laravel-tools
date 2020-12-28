<a class="¤-model¤-edit" href="{{ route('¤_model¤.edit', ['¤_model¤_id' => $¤modelC¤->id]) }}">
    <i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="{{ trans('¤_model¤.edit') }}"></i>
</a>
<a data-toggle="modal" data-target="#delete¤ModelP¤Modal">
    <i
        class="fa fa-times ¤-model¤-delete"
        style="color:red; cursor:pointer;"
        data-id="{{ $¤modelC¤->id }}"
        data-toggle="tooltip"
        data-placement="top"
        title="{{ trans('¤_model¤.delete') }}"
    ></i>
</a>