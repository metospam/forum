<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetRecordsRequest;
use App\Http\Resources\TopicsResource;
use App\Repositories\TopicRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TopicController extends Controller
{

    public function __construct(
        protected TopicRepository $topicRepository
    )
    {

    }

    public function handleGetTopics(GetRecordsRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();
        $topics = $this->topicRepository->getTopics($data);

        return TopicsResource::collection($topics);
    }
}
