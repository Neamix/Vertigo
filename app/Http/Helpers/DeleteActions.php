<?php 

namespace App\Http\Helpers;


trait DeleteActions {
    public function deleteWithDeattach($relation_array)
    {
        foreach( $relation_array as $relation )
        {
            $this->$relation()->detach();
        }

        $this->delete();
    }
}