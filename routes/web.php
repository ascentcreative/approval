<?php

use AscentCreative\Approval\Models\ApprovalItem;
use AscentCreative\Approval\Events\ItemApproved;

Route::middleware('web')->group( function() {

    // Route::get('/test-approval-event/{approval_item}', function(ApprovalItem $ai) {

    //     // $ai = ApprovalItem::find(2);
    //     ItemApproved::dispatch($ai);

    // });

});