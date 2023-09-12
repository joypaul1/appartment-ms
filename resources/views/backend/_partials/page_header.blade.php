<div class="card-header d-flex justify-content-between">
    <span href="#" style="font-size: 18px;font-weight:700">
        @yield('page-header')
    </span>
    @isset($name)
    <a href="@isset($route){{ $route }}@else # @endisset" @isset($target) target="_blank" @endisset class="btn btn-info btn-md ">
        <i class="@isset($fa){{ $fa }}@endisset me-1"></i> {{ $name }}
    </a>
    @endisset
</div>
