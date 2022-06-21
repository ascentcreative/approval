@extends($extend)

{{-- Override the title --}}
@section('screentitle')
   
    {{-- @if (isset($model->id) && $model->id)
        Review Edited {{$modelName}}
    @else
        Review New {{$modelName}}
    @endif --}}

    Review {{$modelName}}

@endsection

{{-- Override the action buttons --}}
@section('headbar')
    <nav class="navbar">
        @section('headactions')
            
            {{-- To be Implemented! --}}
            {{-- <A href="{{ '#' }}"  class="btn btn-primary bi-pencil-fill" class="button">Save draft</A> --}}
            <BUTTON type="submit" class="btn btn-primary bi-check-circle-fill" class="button">Approve {{$modelName}}</BUTTON>
            <A href="{{ action([controller(), 'reject'], ['approval_item' => session('approval_item_id')]) }}"  class="btn btn-primary bi-exclamation-triangle-fill modal-link" class="button">Reject {{$modelName}}</A>
            <A href="{{ session('last_index') }}" class="btn btn-primary bi-x-circle-fill">{{-- Close {{$modelName}} --}} Exit Without Saving</A>

        @show 
    </nav>
@endsection


@section('screen-start')
        
    {{-- OPEN FORM TAG --}}
    @if (isset($model->id) && $model->id)
        <form action="{{ action([controller(), 'approve'], ['approval_item' => $model->id]) }}" id="frm_edit" method="POST" enctype="application/x-www-form-urlencoded" autocomplete="off">
         @method('PUT')
    {{-- @else
        <form action="{{ action([controller(), 'store']) }}" method="POST" id="frm_edit" enctype="application/x-www-form-urlencoded" autocomplete="off"> --}}
    @endif

    @csrf
    {{-- Prevent enter submitting the form --}}
    <input type="submit" disabled style="display: none"/> 

@endsection



{{-- 
    Insert a hidden field containing the approvalitem id - this value is used on 
    the Approvable trait to adjust the status of the approval queue item
    --}}
@section('editform')

    <input type="hidden" name="approval_item_id" value="{{ session('approval_item_id') }}" />

    {{-- If this gets set to 1, force save to update sandbox data rather than attempt to commit a Model --}}
    {{-- <input type="hidden" name="save_to_sandbox" value="0" /> --}}

    @parent

@endsection

