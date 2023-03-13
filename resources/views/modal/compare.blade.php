<x-cms-modal modalid="ajaxModal">

    {{-- {!! \ViKon\Diff\Diff::compare(json_encode($approval_item->$field), $approvable->$field)->toHtml() !!} --}}

    {!! \Mistralys\Diff\Diff::createStyler()->getStyleTag(); !!}
    <table class="text-diff-container">
        <thead>
            <td><strong>Stored Value</strong></td>
            <td><strong>Incoming Value</strong></td>
        </thead>
    </table>
    {!! \Mistralys\Diff\Diff::compareStrings($stored ?? '', $incoming ?? '')->toHtmlTable() !!}

    <style>
        .text-diff-container {
            width: 100%;
        }

        .text-diff-container td {
            /* padding: 20px; */
            width: 50%;
            background: white;
        }
    </style>

</x-cms-modal>


{{-- 
@extends('cms::modal')

@php
    $modalFade = false;
    $modalShowHeader = true;
    //$modalShowFooter = true;
    $modalCenterVertical = false;
    //$modalSize = "modal-lg";
    $modalCloseButton = false;
@endphp



@section('modalTitle')
  Rejection...
@endsection


@section('modalContent')

    <div class="working">    

       Why?
        
    </div>

@endsection --}}