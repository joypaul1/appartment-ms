{{-- how to add your template --}}
{{-- @include('components.backend.forms.texteditor.editor',[ 'name' => 'description' ]) --}}
{{-- default use --}}
{{-- @include('components.backend.forms.texteditor.editor' --}}
@php
$str = ['_', '[', ']'];
$rplc = [' ', ' ', ' '];
$upName = ucfirst(str_replace($str, $rplc, $name));
@endphp
{{-- label end here --}}
<label class="col-form-label" @isset($name) for="{{ $name }}" @endisset>
    {{ $upName }}
    @isset($required)
    <span class="text-danger">*</span>
    @endisset
</label>
{{-- label end here --}}

{{-- textarea --}}
<textarea name="@isset($name){{ $name }}@else  description  @endisset" id="@isset($name){{ $name }}@else  description  @endisset"
    class="editor-textarea" placeholder="@isset($placeholder){{ $placeholder }} @else Enter description here... @endisset">
@isset($value)
{!! $value !!}
@else
{!! old($name)!!}
@endisset
</textarea>
{{-- textarea end --}}

@push('js')

<script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
            .create( document.querySelector( '.editor-textarea' ) )
            .then( editor => {
                    console.log( editor );
            } )
            .catch( error => {
                    console.error( error );
            } );


</script>

@endpush
