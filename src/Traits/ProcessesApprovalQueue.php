<?php

namespace AscentCreative\Approval\Traits;

use AscentCreative\Approval\Models\ApprovalItem;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;


/**
 * Extends a controller to include extra functions to process stored sandbox elements
 */
trait ProcessesApprovalQueue {


    // opens a sandboxed record
    public function approval(ApprovalItem $approval_item) {

        $cls = ($this::$modelClass);
        $model = $cls::approvalQueue()->find($approval_item->approvable_id);

        $data = $this->prepareViewData();

        if(isset($this->approvalModelName)) {
            $data['modelName'] = $this->approvalModelName;
        }
        
        $payload =  $approval_item->payload;
        $payload['approval_item_id'] = $approval_item->id;
        
        if(session()->get('_old_input') === null) {
            // flash the payload to the session for this request only (now())
            request()->session()->now('_old_input', $payload);
        } 
        session()->now('approval_item', $approval_item);
        
        $blade = $this::$bladePath . '.edit';

        if ($this::$formClass) {

            $form = $this->getForm();
            $form->action(action([controller(), 'approve'], ['approval_item' => $model->id]))->method("PUT");
            $form->children([
                \AscentCreative\Forms\Fields\Input::make('approval_item_id', '', 'hidden'),
            ])->populate($model);
            $data['form'] = $form;

            return view('approval::recall.builder', $data)->withModel($model);
        } elseif(view()->exists($blade)) {

            $data['extend'] = $blade;
            return view('approval::recall', $data)->withModel($model);

        }

       
   
        // 
       

    }


    public function approve(Request $request, $id) {

        $qry = $this->prepareModelQuery();
        $model = $qry->approvalQueue()->find($id);

        if($form = $this->getForm()) {
            $form->validate($request->all());
        } else {
            Validator::make($request->all(), 
                    $this->rules($request, $model),
                    $this->messages($request, $model)
                    )->validate();
        }


        // look out for arrays which should be JSON
        // foreach($request->all() as $key=>$tmp) {
        //     if (is_array($request->$key) && substr($key, 0, 1) != "_") {
        //         $request->merge([$key => json_encode($request->$key)]);
        //     }
        // }

        // aaargh - this breaks everywhere that a legitimate array is passed in.
        
        $this->commitModel($request, $model);
        return redirect()->to($request->_postsave);

    }


    public function confirmreject($id) {

        $data = $this->prepareViewData();
        
        if(isset($this->approvalModelName)) {
            $data['modelName'] = $this->approvalModelName;
        }

        return view('approval::modal.reject', $data);

    }

    public function reject(Request $request, $id) {

        Validator::make($request->all(), 
                ['reject_reason'=>'required'],
                ['reject_reason.required' => 'Please give your reasons for rejecting this item']
                )->validate();

        // $qry = $this->prepareModelQuery();
        // $model = $qry->approvalQueue()->find($id);

        // dump($id);

        $ai = ApprovalItem::find($id);
        $ai->reject($request->reject_reason);
        // $model->reject();


        return new JsonResponse(['hard'=>true, 'url'=>session('last_index')], 302);

        // dd($request->all());

        // return redirect()->to(session('last_index'));

        // return 

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

        $data = $this->prepareViewData();
        
        if(isset($this->approvalModelName)) {
            $data['modelName'] = $this->approvalModelName;
            $data['modelPlural'] = Str::pluralStudly($this->approvalModelName);
        }

        $items = ApprovalItem::approvalQueue($cls)->paginate(25); 

        $columns = $this->getApprovalColumns();

        session(['last_index'=> url()->full()]);

        return view($this::$bladePath . '.approval', $data)->with('models', $items)->with('columns', $columns);

    }
  



}