@extends('cms::admin.base.edit.builder')


{{-- Override the title --}}
@section('screentitle')
   
    Review {{$modelName}}

@endsection

{{-- Override the action buttons --}}
@section('headbar')
    <nav class="navbar">
        @section('headactions')
            
            {{-- To be Implemented! --}}
            {{-- <A href="{{ '#' }}"  class="btn btn-primary bi-pencil-fill" class="button">Save draft</A> --}}
            @can('approve')
            <BUTTON type="submit" class="btn btn-primary bi-check-circle-fill" class="button">Approve {{$modelName}}</BUTTON>
            <A href="{{ action([controller(), 'reject'], ['approval_item' => old('approval_item_id')]) }}"  class="btn btn-primary bi-exclamation-triangle-fill modal-link" class="button">Reject {{$modelName}}</A>
            @endcan
            <A href="{{ getReturnUrl() }}" class="btn btn-primary bi-x-circle-fill">{{-- Close {{$modelName}} --}} Exit Without Saving</A>

        @show 
    </nav>  
@endsection


@section('screen')

    @if($approval_item->action == 'edit')
    <div class="alert border rounded alert-warning">
        Changes have been made in the following fields: 
        @foreach(array_keys(session()->get('approval_item')->payload) as $key)
            {{ $form->getElement($key)->label }},
        @endforeach
    </div>
    @endif

    @parent

@endsection


@if($approval_item->action == 'edit')
    @push('scripts')
        <script>

            let keys =  {!! json_encode(array_keys(session()->get('approval_item')->payload)) !!};
        
            keys.forEach(key => {
                // alert('#' + key + "-wrapper");
                $('#' + key + "-wrapper")
                    .addClass('has-changes').css('position', 'relative')
                    .append('<a href="/approval/compare/{{ $approval_item->id }}/' + key + '" style="position: absolute; top: -7px; left: 10px;" class="modal-link badge badge-warning p-1">Compare changes <i class="bi-caret-right-fill"></i></a>'); 
            });


        </script>
    @endpush
@endif