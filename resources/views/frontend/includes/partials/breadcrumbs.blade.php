@if (Breadcrumbs::has() && !Route::is('frontend.index'))
    <nav id="breadcrumbs" aria-label="breadcrumb">
        <ol class="container breadcrumb mb-0">
            @foreach (Breadcrumbs::current() as $crumb)
                @if ($crumb->url() && !$loop->last)
                    <li class="breadcrumb-item">
                        <x-utils.link :href="$crumb->url()" :text="$crumb->title()" />
                    </li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $crumb->title() }}
                    </li>
                @endif
            @endforeach

            <!-- 
            <li class="breadcrumb-item active" aria-current="page">
                MEDIDAS
            </li> -->

            <!-- <li class="c-sidebar-nav-item"> -->
            <li class="breadcrumb-item active" aria-current="page">            
                <x-utils.link
                icon="c-sidebar-nav-icon"
                    :href="route('frontend.measures.index')"
                    class="c-sidebar-nav-link"
                    :text="__('Measures')"
                    :active="activeClass(Route::is('frontend.measures.index.*'), 'c-active')" />
            </li>             

        </ol>
    </nav>
@endif
