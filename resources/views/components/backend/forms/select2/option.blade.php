@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous"
    referrerpolicy="no-referrer" />
@endpush

@php
$str = ['_', '[', ']'];
$rplc = ['', '', ''];
$upName = ucfirst(str_replace($str, $rplc, $name));
if (isset($label)) {
$label = ucfirst(str_replace($str, $rplc, $label));
}
// dd($upName)
@endphp
{{-- label end here --}}

<label class="col-form-label for=" {{ $upName }}">
    {{ $label ?? $upName }}
    @isset($required)
    <span class="text-danger">*</span>
    @endisset
</label>
{{-- label end here --}}
<select class="form-control show-tick ms select2" id="{{ $upName }}" name="{{ $name }}" @isset($multiple) multiple @endisset @isset($onclick)
    onclick="dataBaseCall()" @endisset @isset($onchange) onchange="dataBaseCall()" @endisset @isset($required) required @endisset @isset($readonly)
    readonly @endisset>
    <option value="{{ null }}">- select {{ $label ?? $upName }} -</option>
    @forelse ($optionData as $data)
    <option value="{{ $data['id'] }}" @if(isset($multiple) && isset($selectedKey)) {{ in_array($data['id'], $selectedKey) ? 'selected' : '' }} @else @isset($selectedKey) {{
        $selectedKey==$data['id'] ? 'selected' : ' ' }} @endisset @endif>
        {{ $data['name'] }}
    </option>
    @empty
    @endforelse
</select>

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
@if (isset($name))
<script>
    $("#{{ $upName }}").each(function() {
        $(this).select2();
    });
</script>
@else
<script>
    $(".select2").each(function() {
        $(this).select2();
    });;
</script>
@endif


@endpush
