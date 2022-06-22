<?php

use AscentCreative\Approval\Models\ApprovalItem;
use AscentCreative\Approval\Events\ItemApproved;

Route::middleware('web')->group( function() {

    // Route::get('/test-approval-event', function() {

    //     $ai = ApprovalItem::find(2);
    //     ItemApproved::dispatch($ai);

    // });

});