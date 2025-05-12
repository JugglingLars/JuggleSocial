<?php

namespace App\Jobs;


use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $imgId;

    public function __construct($imgId)
    {
        $this->imgId = $imgId;
    }

    public function handle()
    {
        Log::info('Job started');
        $imageFullName = Image::find($this->imgId)->image_full_name;
        $sourceFullPath = storage_path('app/public/temp/' . $imageFullName);
        $destFullPath=storage_path('app/public/images/' . $imageFullName);

        $this->add_watermark($sourceFullPath, $destFullPath);
        
        unlink($sourceFullPath);
        Log::info('Job ended');
    }

    private function add_watermark($imgPath, $destPath){
        $img = \Intervention\Image\Laravel\Facades\Image::read($imgPath);

        $logo = storage_path('app/private/banner.png');
        $img->place($logo, 'bottom-right', 10, 10);

        $img->save($destPath);
    }
}
