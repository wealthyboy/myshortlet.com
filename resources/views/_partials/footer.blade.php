<footer class=" pt-8 pb-6 footer text-muted fixed-">
    <div class="container container-xxl">

        <div class="mt-0 mt-md-10 row">
            <div class="col-md-12 text-center">
                <ul class="pull-center">
                    @foreach($footer_info as $info)
                    <li>
                        <a href="/pages/{{ $info->slug }}">
                            {{ title_case($info->title) }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-12 copyright text-center">
                <p class="">© Copyright Avenue Montaigne {{ date('Y') }}. All rights reserved.
                    @if ( auth()->check() && auth()->user()->isAdmin() )
                    <a target="_blank" class="text-white" href="/admin">Go to Admin</a>
                    @endif
                </p>
            </div>
        </div>
    </div>
</footer>