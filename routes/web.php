<?php

use AscentCreative\Approval\Models\ApprovalItem;
use AscentCreative\Approval\Events\ItemApproved;

use AscentCreative\Approval\FineDiff\FineDiff;

Route::middleware('web')->group( function() {

    // Route::get('/test-approval-event/{approval_item}', function(ApprovalItem $ai) {

    //     // $ai = ApprovalItem::find(2);
    //     ItemApproved::dispatch($ai);

    // });

    Route::get('/approval/compare/{approval_item}/{field}', function (ApprovalItem $approval_item, $field) {

        $approvable = $approval_item->approvable;

        // need to somehow convert all values to strings (<PRE>?)
        // ok for basic field values, but need to handle array data / relations

        // so, first of all, convert everything to an array?
        $incoming = $approval_item->$field;
        $stored = $approvable->$field;

        // if(!is_array($stored)) {
        //     if($stored instanceof \Illuminate\Database\Eloquent\Collection) {
        //         $stored = $stored->toArray();
        //     }
        // }

        if($field == 'lyrics') {

        // if the field is a relation (exits as a method - and returns a relation)
        if(method_exists($approvable, $field) && ($rel = $approvable->$field()) instanceof \Illuminate\Database\Eloquent\Relations\Relation) {
            // dump($rel->getRelated());
            $cls = get_class($rel->getRelated());
            // dump($cls);
            foreach($incoming as $idx => $inc) {
                $temp = new $cls();
                $temp->fill($inc);
                $incoming[$idx] = $temp;
            }
            // dd($incoming);
        }

        $incString = '';
        foreach($incoming as $inc) {
            $ary = [];
            if($inc->lyricsection) {
                $ary[] = $inc->lyricsection->title;
            }
            $ary[] = $inc->lyrics;
            $incString .= join("\n", array_filter($ary)) . "\n\n";
        }


        $stString = '';
        foreach($stored as $inc) {
            $ary = [];
            if($inc->lyricsection) {
                $ary[] = $inc->lyricsection->title;
            }
            $ary[] = $inc->lyrics;
            $stString .= join("\n", array_filter($ary)) . "\n\n";
        }

        $incoming = $incString;
        $stored = $stString;

        }

   
    // echo \AscentCreative\Approval\FineDiff\FineDiff::renderDiffToHTMLFromOpcodes($stored, $opcodes);

        // echo \Mistralys\Diff\Diff::createStyler()->getStyleTag();
        // echo \Mistralys\Diff\Diff::compareStrings($stString, $incString)->toHtmlTable();

        // echo \Mistralys\Diff\Diff::compareStrings($stString, $incString)->toHtml();

        // echo \Mistralys\Diff\Diff::compareStrings($stString, $incString)->toString();

        // dump(\Mistralys\Diff\Diff::compareStrings($stString, $incString)->toArray());

        return view('approval::modal.compare', ['approval_item'=>$approval_item, 'approvable'=>$approvable, 'field'=>$field, 'incoming'=>$incoming, 'stored'=>$stored]);

    });

});