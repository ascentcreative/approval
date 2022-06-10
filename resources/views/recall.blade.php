@extends($extend)

{{-- Override the title --}}
@section('screentitle')
   
    @if (isset($model->id) && $model->id)
        Review Edited {{$modelName}}
    @else
        Review New {{$modelName}}
    @endif

@endsection

{{-- Override the action buttons --}}
@section('headbar')
    <nav class="navbar">
        @section('headactions')
            
            <A href="{{ '#' }}"  class="btn btn-primary bi-pencil-fill" class="button">Save draft</A>
            <BUTTON type="submit" class="btn btn-primary bi-check-circle-fill" class="button">Approve {{$modelName}}</BUTTON>
            <A href="{{ '#' }}"  class="btn btn-primary bi-exclamation-triangle-fill" class="button">Reject {{$modelName}}</A>
            <A href="{{ session('last_index') }}" class="btn btn-primary bi-x-circle-fill">{{-- Close {{$modelName}} --}} Exit Without Saving</A>

        @show 
    </nav>
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

