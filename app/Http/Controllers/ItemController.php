<?php

namespace App\Http\Controllers;

use App\Repositories\ItemsRepository;
use App\Http\Resources\ItemResource;
use Illuminate\Http\Request;

class ItemController extends Controller
{


    private $itemRepository;

    public function __construct(ItemsRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function creatItem(Request $request)
    {
        $validation = $this->itemRepository->itemPostValidation($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }

        $item = $this->itemRepository->createItem($request);

        if ($item) {
            return $this->apiResponse(['item' => $item], null, 201);
        }

        return $this->unKnowError('error while create the item');
    }


    public function getAllItems(Request $request)
    {
        $items = $this->itemRepository->getAllItems($request);
        if ($items) {
            return $this->apiResponse(ItemResource::collection($items));
        } else {
            return $this->notFoundResponse("There is no items");
        }
    }

    public function getItem($id)
    {
        $item = $this->itemRepository->getItem($id);
        if ($item) {
            return $this->apiResponse(new ItemResource($item));
        } else {
            return $this->notFoundResponse("There is no item matching this id");
        }
    }

    public function updateItem(Request $request)
    {
        $validation = $this->itemRepository->itemPostValidation($request);

        if ($validation instanceof \Illuminate\Http\Response) {

            return $validation;
        }

        $item = $this->itemRepository->updateItem($request);

        if ($item) {
            return $this->apiResponse("successfully updated");
        }

        return $this->unKnowError('error while update the item');
    }

}
