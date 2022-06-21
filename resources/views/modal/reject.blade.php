<x-cms-modal modalid="ajaxModal">

    <x-slot name="formstart">
        <form action="{{ url()->current() }}" method="post" xclass="no-ajax">
            @csrf
    </x-slot>


    <x-slot name="title">Reject {{ $modelName }}</x-slot>

    <x-cms-form-textarea name="reject_reason" value="" label="Please enter the reasons for rejection:" rows="20" wrapper="simple">
        Internal use only. Information entered here will not be sent to the submitter.
    </x-cms-form-textarea>

    <x-slot name="footer">
        <button class="btn btn-small btn-secondary" data-dismiss="modal">Cancel</button>

        <button class="btn btn-small btn-primary" id="btn_confirm">Proceed and Reject</button>
    </x-slot>


    <x-slot name="formend">
        </form> 
    </x-slot>



<script>
 $(document).on('click', '#btn_confirm', function(e) {
    // alert('ok');
    // e.preventDefault();
    $('#frm_edit').trigger('reinitialize.areYouSure');

 });

</script>



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