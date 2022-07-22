<?php 

namespace App\Services;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait ImageService {

    protected $dimintionsArray = [];
    protected $service = 'fit';
    protected $files = [];
    protected $relation;
    protected $use_for = null;
    protected $store = false;
    protected $prefix = '';

    public function dimintions($dimintions)
    {
        $this->dimintionsArray = $dimintions;
        return $this;
    }

    public function fit()
    {
        $this->service = 'fit';
        return $this;
    }

    public function resize()
    {
        $this->service = 'resize';
        return $this;
    }

    public function store()
    {
        $this->store = true;
        return $this;
    }

    public function withSaveRelation($relation)
    {
        $this->relation = $relation;
        return $this;
    }

    public function prefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function files($files)
    {   
        if( is_array($files) ) {
            $this->files = $files;
        } else {
            $this->files = [$files];
        }

        return $this;
    }

    public function usefor($use_for)
    {
        $this->use_for = $use_for;
        return $this;
    }

    public function compile()
    {
        $names = [];
        $root = public_path($this->root);

        foreach( $this->files as $file )  {

            $unique_name  = $this->prefix . time() . uniqid() . '.' . $file->extension();

            if ( $file->extension() !== 'svg' )  {


                $file_path = Image::make($file->getRealPath());


                foreach( $this->dimintionsArray as $size => $dimintion ) {
                        array_push($names,$unique_name);
                        $dimintion_explode = explode('x',$dimintion);

                        if( $this->service == 'fit' ) {
                            $file = $file_path->fit($dimintion_explode[0], $dimintion_explode[1], function ($constraint) {
                                $constraint->upsize();
                            });
                        } else {
                            $file = $file_path->resize($dimintion_explode[0], $dimintion_explode[1], function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }

                        if ($this->store) {

                            if (! File::exists($root.'/'.$size)) {
                                File::makeDirectory($root.'/'.$size, $mode = 0777, true, true);
                            }

                            $file->save($root.'/'."$size/".$unique_name);
                        }
                        
                }

            } else {
                if ( $this->store ) {
                    move_uploaded_file($file->getRealPath(),$root.'/small/'.$unique_name);
                }
            }

            

            if( $this->relation ) {

                $relation = $this->relation;

                $this->$relation()->create(['name' => $unique_name,'use_for' => $this->use_for]);

            }

        }

        return $names;
    }

    public function deleteImagesWithIdsBelongsToRelation($ids,$root = null,$relation = null) {

        $root = public_path($root);

        $files  = $this->$relation->whereIn('id',$ids);

        
        $dirictoris  = scandir($this->root);

        foreach($dirictoris as $dirictory) {
            if( is_dir(public_path($this->root.'/'.$dirictory) ) ) {

                foreach($files as $file) {
                    File::delete(public_path($this->root.'/'.$dirictory.'/'.$file->name));
                }


            }

        }

        $this->$relation()->whereIn('id',$ids)->delete();
        

    }

    public function deleteImageByName($path) 
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }

    public function removeReleatedImage($relation = 'gallaries',$root = null)
    {
        
        if( ! $root ) {

            $dirictoris  = scandir($this->root);

            foreach($dirictoris as $dirictory) {
                if( is_dir(public_path($this->root.'/'.$dirictory) ) ) {

                    foreach($this->$relation as $file) {
                        File::delete(public_path($this->root.'/'.$dirictory.'/'.$file->name));
                    }

                }

            }

        }

    }

}