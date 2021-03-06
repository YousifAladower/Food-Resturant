<header class="site-header shadow-bottom py-lg-0 py-3">
    <div class="container">
        <nav class="navbar navbar-expand-lg font-body-bold px-0">
            <a href="{{ url("/") }}" class="navbar-brand site-logo mr-0">
                <img src="{{ url("/assets/site/img/logo.png") }}"
                     width="115"
                     height="56"
                     alt="Site Logo">
            </a><!-- .site-logo -->
            <button class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#top-navigation"
                    aria-controls="top-navigation"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="top-navigation">
                <ul class="nav navbar primary-menu flex-column flex-lg-row">
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link text-secondary px-xl-3 px-2">{{trans('site.home')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/#offers') }}" class="nav-link text-secondary px-xl-3 px-2">{{trans('site.offers')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/#categories') }}" class="nav-link text-secondary px-xl-3 px-2">{{trans('site.cats')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/#app') }}" class="nav-link text-secondary px-xl-3 px-2">{{trans('site.apps')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/#contact') }}" class="nav-link text-secondary px-xl-3 px-2">  {{trans('site.contact_us')}}</a>
                    </li>

                  @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                    @if(LaravelLocalization::getCurrentLocale()  != $localeCode )
                        <li class="nav-item"> 
                            <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                {{ $properties['native'] }}
                            </a>
                        </li>
                    @endif
                @endforeach

                </ul><!-- .primary-menu -->

                    

                <div class="client-area mt-lg-0 mt-md-2 mt-sm-0 d-flex justify-content-center">
                    <a href="{{ url('/register') }}"
                       class="btn btn-outline-primary px-3 px-sm-4 ml-2">
                        {{trans('site.register')}}
                    </a>
                    <a href="{{ url('/login') }}"
                       class="btn btn-primary px-3 px-sm-4 mr-2">
                        {{trans('site.login')}}
                    </a>
                </div><!-- .client-area -->
            </div>
        </nav>
    </div>
</header><!-- .site-header -->
 