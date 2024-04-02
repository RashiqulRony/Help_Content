<?php

namespace App\Traits;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

trait MediaUpload
{
    public $basePath = '';
    public $originalPath = '';
    public $file = '';
    public $name = '';
    public $thumbPath = '';
    public $thumb = false;
    public $storageFolder = 'storage/';
    public $imageResize = [];
    public $thumbResize = [300, 300];


    //Common File Upload Function...
    private function upload()
    {
        $file = $this->file;
        if ($this->name) {
            $fileName = Str::slug($this->name, '-').'.'.$file->getClientOriginalExtension();
        } else {
            $newName = str_replace('.'.$file->getClientOriginalExtension(), '', $file->getClientOriginalName());
            $fileName = time().'-'.Str::slug($newName, '-').'.'.$file->getClientOriginalExtension();
        }
        $data['name'] = $fileName;
        $data['originalName'] = $file->getClientOriginalName();
        $data['size'] = $file->getSize();
//        $data['mime_type'] = $file->getMimeType();
        $data['ext'] = $file->getClientOriginalExtension();
        $data['url'] = url($this->storageFolder.$this->originalPath.$data['name']);

        //If real image need to resize...
        if (!empty($this->imageResize)) {
            $imageManager = new ImageManager(new Driver());
            $file = $imageManager->read($file)->resize($this->imageResize[0], $this->imageResize[1]);
            Storage::put($this->originalPath.'/'.$fileName, (string) $file->encode());
        } else {
            Storage::putFileAs($this->originalPath, $file, $data['name']);
        }

        if ($this->thumb) {
            $imageManager = new ImageManager(new Driver());
            $imageManager->read($this->storageFolder.$this->originalPath.$data['name'])
                ->resize($this->thumbResize[0], $this->thumbResize[1])
                ->save($this->storageFolder.$this->thumbPath.'/'.$data['name']);
        }
        return $data;
    }

    //Upload Image ("$definePath" and "$definePath/thumb") folder....
    public function imageUpload($requestFile, $path, $thumb = false, $name = null, $imageResize = [], $thumbResize = [300, 300])
    {
        //Path Create...
        $realPath = $this->basePath.$path.'/';
        if (!Storage::exists($realPath)) {
            Storage::makeDirectory($realPath);
        }

        if (!Storage::exists($realPath.'thumb') && $thumb) {
            Storage::makeDirectory($realPath.'thumb');
        }

        $this->file = $requestFile;
        $this->originalPath = $realPath;
        $this->thumbPath = $realPath.'thumb';
        $this->thumb = $thumb;
        $this->name = $name;
        $this->imageResize = $imageResize;
        $this->thumbResize = $thumbResize;
        return $this->upload();
    }

    //Upload Video in "$definePath" folder....
    public function videoUpload($requestFile, $path, $name = null)
    {
        //Path Create...
        $realPath = $this->basePath.$path.'/';
        if (!Storage::exists($realPath)) {
            Storage::makeDirectory($realPath);
        }

        $this->file = $requestFile;
        $this->originalPath = $realPath;
        $this->name = $name;
        return $this->upload();
    }

    //Upload AnyFile in "$definePath" folder....
    public function fileUpload($requestFile, $path, $name = null)
    {
        //Path Create...
        $realPath = $this->basePath.$path.'/';
        if (!Storage::exists($realPath)) {
            Storage::makeDirectory($realPath);
        }

        $this->file = $requestFile;
        $this->originalPath = $realPath;
        $this->name = $name;
        return $this->upload();
    }


    //Upload Content in "$definePath" folder....
    public function contentUpload($content, $path, $name)
    {
        //Path Create...
        $realPath = $this->basePath.$path.'/';
        if (!Storage::exists($realPath)) {
            Storage::makeDirectory($realPath);
        }

        Storage::put($name, $content);

        $data['name'] = $name;
        $data['url'] = $path.'/'.$name;
        return $data;
    }

    //Only thumb image create in "$definePath/thumb" folder....
    public function thumb($path, $file, $thumbPath = false, $thumbWidth = 300, $thumbHeight = 300)
    {
        $realPath = $this->basePath.$path;
        if (!$thumbPath) {
            $thumbPath = $this->basePath.$path.'/thumb';
        }

        if (!Storage::exists($thumbPath)) {
            Storage::makeDirectory($thumbPath);
        }
        $imageManager = new ImageManager(new Driver());
        $img = $imageManager->read($this->storageFolder.$realPath.'/'.$file)
            ->resize($thumbWidth, $thumbHeight)
            ->save($this->storageFolder.$thumbPath.'/'.$file);

        if (isset($img->filename)) {
            return true;
        } else {
            return false;
        }
    }

    //Delete file "$definePath" folder....
    public function mediaDelete($path, $file, $thumb = false)
    {
        $path = $this->basePath.$path.'/';
        if (Storage::exists($path.'/'.$file)) {
            Storage::delete($path.'/'.$file);

            if ($thumb) {
                Storage::delete($path.'/thumb/'.$file);
            }
            return true;
        }
        return false;
    }

    //Delete file "$definePath" folder....
    public function removeDir($path)
    {
        $realPath = $this->basePath.$path.'/';
        if (Storage::exists($realPath)) {
            Storage::deleteDirectory($realPath);
        }
        return true;
    }
}
