<div class="nav">
    <div class="container navbar">
        <a class="navbar-brand" href="{{ route('index.page') }}">
            <div class="itech-logo">
                @forelse($footer as $item)
                    <img src="{{ asset($item->logo) }}" alt="">

                @empty
                    <img src="{{ url('upload/no_image.jpg') }}" alt="">
                @endforelse
            </div>
        </a>

        <a href="#" class="toggle-button">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </a>
        <div class="navbar-links">
            <ul>
                <li>
                    <a href="{{ route('index.page') }}">@lang('header.home')</a>
                </li>
                <div class="vertical"></div>
                <li><a href="{{ route('home.about') }}" class="nav-links"
                        data-href="{{ route('home.about') }}">@lang('header.aboutus')</a></li>
                <div class="vertical"></div>
                <li><a href="{{ route('home.contact') }}" class="nav-links">@lang('header.contact')</a>
                </li>
                <div class="vertical"></div>
                <li><a href="{{ route('all.post.page') }}" class="nav-links">@lang('header.events')</a>
                </li>
                <div class="d-lg-inline-block">
                    <a href="#" class="nav-link" id="navbarDropdownMenuLink" data-toggle="dropdown">
                        @php
                            $lang = App::getLocale();
                        @endphp
                        <span class="{{ $lang == 'en' ? 'fi fi-us' : 'fi fi-la' }}"></span>
                        {{ $lang == 'en' ? 'English' : 'ລາວ' }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                        @foreach (config('app.available_locales') as $locale)
                            <a class="mx-1" style="text-decoration: none"
                                href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => $locale])) }}">
                                @if ($lang == 'en')
                                    @if ($locale == 'la')
                                        <span class="fi fi-la"></span><span style="color:white; font-size:0.9rem">
                                            ລາວ</span>
                                    @endif
                                @endif

                                @if ($lang == 'la')
                                    @if ($locale == 'en')
                                        <span class="fi fi-us"></span><span style="color: white; font-size:0.9rem">
                                            English</span>
                                    @endif
                                @endif

                            </a>
                        @endforeach

                    </div>
                </div>
            </ul>
        </div>
    </div>
</div>
