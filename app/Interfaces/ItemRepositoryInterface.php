<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ItemRepositoryInterface {
    public function getAllItems();
    public function getItem($id);
    public function createItem(Request $request);
    public function updateItem(Request $request);
    public function itemPostValidation(Request $request);

}