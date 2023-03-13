<x-cms-modal modalid="ajaxModal" :showHeader="false" :showFooter="true">

    @php
    
        $opcodes = \AscentCreative\Approval\FineDiff\FineDiff::getDiffOpcodes($stored, $incoming); // /, default granularity is set to character */);

    @endphp



    <table class="table">

        <thead>
            <tr>
                <th width="50%">Stored</th>
                <th width="50%">Incoming</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div style="white-space: pre-wrap" class="diff-stored">{!! \AscentCreative\Approval\FineDiff\FineDiff::renderDiffToHTMLFromOpcodes($stored, $opcodes) !!}</div>
                </td>
                <td>
                    <div style="white-space: pre-wrap" class="diff-incoming">{!! \AscentCreative\Approval\FineDiff\FineDiff::renderDiffToHTMLFromOpcodes($stored, $opcodes) !!}</div>
                </td>
            </tr>
        </tbody>
    </table>

    <style>

        .diff-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .diff-stored INS {
            display: none;
        }

        .diff-incoming DEL {
            display: none;
        }


         DEL{
            color:#979797;
            background:#ffe1e1;
            border-radius:2px;
            display:inline-block;
            /* padding:1px 4px; */
        }

        INS{
            color:#1f361f;
            background:#d0ffd0;
            border-radius:2px;
            display:inline-block;
            /* padding:1px 4px; */
        }

       
    </style>

    <x-slot name="footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
    </x-slot>

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