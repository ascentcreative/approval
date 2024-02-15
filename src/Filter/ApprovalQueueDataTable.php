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


        //     Column::make('Name')
        //         ->width('minmax(200px, 1fr)')
        //         ->valueProperty('lastFirst')
        //         ->filterScope('byName')
        //         ->filterBlade('filter::ui.filters.text')
        //         ->link(function($item) {
        //             return route('portal.contacts.show', ['contact'=>$item]);
        //         })
        //         ->sortScope('sortByName'),

        //     Column::make('Email')
        //         // ->width('2fr')
        //         ->valueProperty('email')
        //         ->filterable(true)
        //         ->copyable()
        //         ->sortable(),

        //     Column::make("Catalogues")
        //         ->width('175px')
        //         ->valueBlade('portal.contacts.index.catalogues')
        //         ->filterScope('byActiveCatalogue')
        //         ->filterBlade('filter::ui.filters.checkboxes', \App\Models\Catalogue::earnsIncome()->get()->keyBy('id')->transform(function ($item) { return $item->title; })),

        //     Column::make('Works Owned')
        //         ->width('minmax(10px, 150px)')
        //         ->value(function($item) { 
        //             return $item->works_count;
        //         })
        //         ->align('center'),

        ];

  
    }

    public function buildQuery() {
        return ApprovalItem::approvalQueue($this->modelClass)
                    ->with("approvable")
                    ->select('*');
    }




}