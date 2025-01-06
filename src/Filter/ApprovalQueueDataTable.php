<?php
namespace AscentCreative\Approval\Filter;

use AscentCreative\Filter\DataTableBuilder;
use AscentCreative\Filter\DataTable\Column;

use AscentCreative\Approval\Models\ApprovalItem;

use Illuminate\Support\Facades\DB;


class ApprovalQueueDataTable extends DataTableBuilder {

    public $defaults = [
        'sort' => ['created_at'=>'asc']
    ];

    public $default_sort = 'created_at asc';

    public function boot() {
        parent::boot();

        $this->setFilterWrapper('');
    
    }


    public function columns() : array {

        $actions = [];
        try {
            $actions =  DB::table('approval_queue')
            ->select('action_label')
            ->distinct()
            ->get()
            ->mapWithKeys(function($item){
                return [$item->action_label => $item->action_label];
            });

        } catch(\Exception $e) {

        }
      
       
        return [

            Column::make("Submitted")
                ->width('150px')
                ->valueProperty('created_at'),

            Column::make('Action')
                ->width('100px')
                ->valueBlade('approval::queue.action-badge')
                ->filterScope('byActionLabel')
                ->filterBlade("filter::ui.filters.checkboxes", 
                            $actions
                        ),

        ];

  
    }

    public function buildQuery() {
        return ApprovalItem::approvalQueue($this->modelClass)
                    ->with("approvable")
                    ->select('*');
    }




}