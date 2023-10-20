<?php

namespace Modules\Section\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Section\Transformers\Api\SectionResource;
use Modules\Section\Repositories\Api\SectionRepository as Section;
use Modules\Apps\Http\Controllers\Api\ApiController;

class SectionController extends ApiController
{

    function __construct(Section $section)
    {
        $this->section = $section;
    }

    public function sections()
    {
        $sections =  $this->section->getAllActive();

        return SectionResource::collection($sections);
    }

    public function section($id)
    {
        $section = $this->section->findById($id);

        if(!$section)
          return $this->response([]);

        return $this->response(new SectionResource($section));
    }
}
