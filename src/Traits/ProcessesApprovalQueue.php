<?php

namespace AscentCreative\Approval\Traits;

use AscentCreative\Approval\Models\ApprovalItem;

use Illuminate\Http\Request;


/**
 * Extends a controller to include extra functions to process stored sandbox elements
 */
trait ProcessesApprovalQueue {

    // opens a sandboxed record
    public function approval(ApprovalItem $approval_item) {

        $cls = ($this::$modelClass);
        $model = new $cls(); // model is blank, we're actually going to drop the data into the 'old' in the session so the system essentially reloads the request
   
        if(session()->get('_old_input') === null) {
        // flash the payload to the session for this request only (now())
            request()->session()->now('_old_input', $approval_item->payload);
        } 
        session()->now('approval_item_id', $approval_item->id);
   
        return view('approval::recall', $this->prepareViewData())->with('extend', $this::$bladePath . '.edit')->withModel($model);

    }

    /**
     * 
     * Lists all the sandboxes linked to the model class
     * 
     * @return [type]
     */
    public function approval_queue() {

        $cls = ($this::$modelClass);

        // $items = $cls::approvalQueue()->get();

        $items = ApprovalItem::approvalQueue($cls)->get(); 

        session(['last_index'=> url()->full()]);

        return view($this::$bladePath . '.approval', $this->prepareViewData())->with('models', $items);

    }
  

}