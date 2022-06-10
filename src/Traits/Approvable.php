<?php

namespace AscentCreative\Approval\Traits;

use AscentCreative\Approval\Models\ApprovalItem;

use Illuminate\Http\Request;


/**
 * Allows a Model to be extended with functions to intercept the save of new data
 * and divert to a sandbox record where needed
 */
trait Approvable {

    public $_ai;

    public static function bootApprovable() {

        // this should be in a scope class so that it allows other scopes to remove it
        // (See how SoftDeleteScope works for more info)
        static::addGlobalScope('approved', function($query) {

            // should we also include a field locally on the model which will protected against any
            // accidental clearing of the approval item records? Probably best to, otherwise there's a risk of 
            // unapproved records suddenly going live.

            $query->where('is_approved', 1)->where('is_rejected', 0);

            $query->whereDoesntHave('approval_items', function($q) {
                $q->where('is_approved', 0)->where('action', 'create');
            });

        });


        static::saving(function($model) {

            if(request()->user()->can('createWithoutApproval', get_class($model))) {

                $model->is_approved = 1;

            } else {

                $model->_ai = new ApprovalItem();
                $model->_ai->fill([
                    'approvable_type' => get_class($model),
                    'approvable_id' => $model->id,
                    'author_id' => auth()->user()->id,
                    'payload' => $model,
                ]);

            }

        });

        // Need to act slightly differently based on if we're creating a new model, or updating an existing one
        static::saved(function($model) { 

            // dd($model->wasRecentlyCreated); 

            // The model row still needs to be created in the database, so we're firing this after the model is created.
            // (we have edge cases which require it to be there, even as a placeholder, so it can be linked to some tentative relationships)

            // However, we need to not write most relationship data to their tables, so we'll filter that out.

            // only write the input values which are directly on the table. 

            // trait (relationship) values should be sidelined and stored in JSON 
            // so they don't create related models. These will be written formally when this record is approved.

            // or, write in the bare minimum data (i.e. required cols only) to get the record into the database,
            // perhaps using dummy data. 

            

            if($model->wasRecentlyCreated) {
                if(!request()->user()->can('createWithoutApproval', get_class($model))) {

                    // $sbx = new ApprovalItem();
                    $model->_ai->fill([
                        'approvable_id' => $model->id,
                        'action' => 'create',
                        
                    ]);


                    $model->_ai->save();

                    return false;

                }
            }

           
            // if the save is allowed, check if there's a sandbox_id, and mark it approved:
                if(request()->approval_item_id) {
                    ApprovalItem::find(request()->approval_item_id)->approve();
                }
    

        });


    



        static::updating(function($model) {
            // dd('Updating');
            // dd($model);
            
            // is the user authorised to do this directly, or does it need to go to the approval_queue?
           if(!request()->user()->can('updateWithoutApproval', get_class($model))) {


                // no?

                // create incoming change record, copmaring the saved data to the incoming (and only list changes)
                // return false; // bail on the save so the updates don't hit the database.

            
                

            }
                


            


        });


  
    }



    public function approval_items() {
        return $this->morphMany(ApprovalItem::class, 'approvable');
    }

    public function scopeApprovalQueue($q) {

        $q->withoutGlobalScope('approved');

        $q->whereHas('approval_items', function($q) {
            $q->where('is_approved', 0);
        });

    }

    public function scopeWithUnapproved($query) {

        $query->withoutGlobalScope('approved');

    }
  

}