<form action="{{ route($route, ['id' => $¤modelC¤->id]) }}" method="POST">
    @method($method)
    @csrf

    <section class="¤-model¤ row">
        <div class="col-12 form-control-nav">
            <a href="{{ route('¤_model¤.index') }}" class="btn btn-primary"><span class="fa fa-arrow-left"></span> {{ trans('app.back' ) }}</a>
            <button class="btn btn-primary" type="submit"><span class="fa fa-save"></span> {{ trans($route) }}</button>
        </div>
        <div class="clearfix"><br/></div>

        @include('¤modelC¤.partials.inputs')

        <div class="w-100"></div>
    </section>
</form>