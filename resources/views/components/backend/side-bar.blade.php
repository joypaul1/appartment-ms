<li {{ $attributes->merge(["class"=>" "]) }}>
    <a href="{{ route($link)}}" @isset($target) target="{{ $target }}"   @endisset>
        @isset($icon)
        <i class="{{ $icon }}"></i>
        @endisset
    <span>{{$name}}</span></a>
</li>

