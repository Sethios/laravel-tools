                @can('view ¤_model¤')
                    <li class="treeview">
                        <a href="{{ route('¤_model¤.index') }}"><i class="fa fa-cogs"></i> <span>{{ trans('¤_model¤.index_plural') }}</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            @can('view ¤_model¤')
                                <li {{ (Route::currentRouteName() == "¤_model¤.index" ? 'class=active' : '') }}>
                                    <a href="{{ route('¤_model¤.index') }}"><i class="fa fa-list-alt"></i> <span>{{ trans('¤_model¤.index_list') }}</span></a>
                                </li>
                            @endcan
                            @can('create ¤_model¤')
                                <li {{ (Route::currentRouteName() == "¤_model¤.new" ? 'class=active' : '') }}>
                                    <a href="{{ route('¤_model¤.new') }}"><i class="fa fa-plus"></i> <span>{{ trans('¤_model¤.new') }}</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan