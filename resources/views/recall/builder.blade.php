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
            <BUTTON type="submit" class="btn btn-primary bi-check-circle-fill" class="button">Approve {{$modelName}}</BUTTON>
            <A href="{{ action([controller(), 'reject'], ['approval_item' => old('approval_item_id')]) }}"  class="btn btn-primary bi-exclamation-triangle-fill modal-link" class="button">Reject {{$modelName}}</A>
            <A href="{{ session('last_index') }}" class="btn btn-primary bi-x-circle-fill">{{-- Close {{$modelName}} --}} Exit Without Saving</A>

        @show 
    </nav>
@endsection