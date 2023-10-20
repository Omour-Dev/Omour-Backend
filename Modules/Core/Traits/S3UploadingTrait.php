<?php

namespace Modules\Core\Traits;

use Illuminate\Support\Str;
use Storage;

trait S3UploadingTrait
{
		public function uploadVideos($video)
		{
				$path = Storage::disk('s3')->putFileAs(
						 'videos',
						 $video,
						 Str::uuid().'.mp4',
						 'public'
				 );

				return Storage::disk('s3')->url($path);
		}


		public function uploadingVideosWithMedia($model,$file)
		{
				$model->addMedia($file)
							->addCustomHeaders([
									'ACL' => 'public-read',
									'visibility'  => 'public',
							])
							->usingFileName(Str::uuid().'.mp4')
							// ->toMediaCollection('videos');
							->toMediaCollection('video_response');
		}
}
