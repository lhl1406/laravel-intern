<?php

namespace App\Observers;

use App\Libs\ValueUtil;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ModelObserver
{
    /**
     * Handle the model "creating" event.
     * 
     * @param Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function creating($model) {
        $model->created_date = Carbon::now();
        $model->updated_date = Carbon::now();
    }
 
    /**
     * Handle the model "updating" event.
     * 
     * @param Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function updating($model) {   
        $model->updated_date = Carbon::now();
    }
 
    /**
     * Handle the model "restored" event.
     * @param Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function restored($model) {
    }
 
    /**
     * Handle the model "forceDeleted" event.
     * @param Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function forceDeleted($model) {
    }
}
