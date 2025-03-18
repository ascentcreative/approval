# Ascent Creative Model Approvals

This package allows for the creation of approvals processes which prevent newly created models (or edits to existing models) being put live without admin approval

## Requirements
 - Laravel 11+
 - ascentcreative/cms
 - ascentcreative/forms
 

## Setting up approvals
 - Run migrations to create the `approval_queue` table.

 - Add the `AscentCreative\Approval\Traits\Approvable` trait to your model. This will add the necessary global scopes to ensure unapproved models are not returned in queries
   
 - Use a migration to add approval columns to your table:

```
    public function up(Blueprint $table) {
        ...
        $table->approvals();
        ...
    }
``` 

 - Create the necessary routes for the approval cycle (usually within the `/admin` prefix)

 ```
    Route::approval('path', Model::class);
 ```

  - (Optional) Implement event listeners for `AscentCreative\Approval\Events\ItemApproved` for tasks like sending emails when items are approved and go live.

