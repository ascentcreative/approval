<?php

namespace AscentCreative\Approval\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use AscentCreative\Sandbox\Events\NewSandbox;
use AscentCreative\Sandbox\Events\UpdatedSandbox;

use Spatie\Activitylog\Traits\LogsActivity;

class ApprovalItem extends Model {

    use LogsActivity;

    public $table = "approval_queue";

    public $fillable = ['approvable_type', 'approvable_id', 'author_id', 'payload', 'action', 'is_approved', 'approved_at', 'approved_by', 'is_rejected', 'rejected_at', 'rejected_by'];

    public $casts = [
        'payload' => 'array',
    ];

    public static function booted() {

        // static::created(function($model) { 
            
        //     NewSandbox::dispatch($model);

        // });

    }

    public function getStatusAttribute() {

    }

    public function approvable() {
        return $this->morphTo()->withUnapproved();
    }

    public function approve() {
        $this->is_approved = 1;
        $this->approved_at = now();
        $this->approved_by = auth()->user()->id;
        $this->save();
    }

    public function reject($reason) {
        $this->is_rejected = 1;
        $this->rejected_at = now();
        $this->rejected_by = auth()->user()->id;
        $this->save();

        // update the model too:
        $model = $this->approvable; //->update(['is_rejected' => 1]);
        $model->is_rejected = 1;
        $model->save();
        
    }

    public function scopeApprovalQueue($query, $class) {
        return $query->where("is_approved", 0)
                    ->where("is_rejected", 0)
                    ->where('approvable_type', $class);
    }
   
}