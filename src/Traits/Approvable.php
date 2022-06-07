<?php

namespace AscentCreative\Sandbox\Traits;

use AscentCreative\CMS\Traits\Extender;
use AscentCreative\Sandbox\Models\Sandbox;

use Illuminate\Http\Request;


/**
 * Allows a Model to be extended with functions to intercept the save of new data
 * and divert to a sandbox record where needed
 */
trait Sandboxable {

    public static function bootSandboxable() {
  
        static::saving(function($model) { 

            // Detect the logic for this model as to whether it needs to be diverted to the sandbox.
            // Where should the logic reside? 
            //   - In a model function?
            //   - Extend the Policy?
            //   - Use a new type of Policy (SandboxPolicy)?


            if(request()->user()->cannot('createWithoutSandbox', get_class($model))) {

                $sbx = new Sandbox();
                $sbx = Sandbox::create([
                    'sandboxable_type' => get_class($model),
                    'sandboxable_id' => $model->id,
                    'action' => $model->id ? 'edit' : 'create',
                    'author_id' => auth()->user()->id,
                   // 'payload' => request()->all(),
                   'payload'=>$model
                ]);


                $model = $sbx;
                // return $model;
                // should this be detecting changed fields?
                // or should we be logging that at the point of approval?
                // Site should be able to show what values will change on an edit.

                
                // I think we should only store fields which changed at the time of edit.
                // That way we can more easily merge them in with the state of the taregt record (i.e. if other edits have been made in the meantime)
                // Note - there will need to be some way of detecting and resolving conflicts.

                return false;

            }

            // if the save is allowed, check if there's a sandbox_id, and mark it approved:
            if(request()->sandbox_id) {
                Sandbox::find(request()->sandbox_id)->approve();
            }

        });
  
    }
  

}