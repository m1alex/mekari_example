<?php

namespace App\Http\Controllers;

use Exception;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Item;

class ItemController extends Controller
{
    protected function errorResponse($message, $errors)
    {
        return [
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ];
    }
    
    
    /**
     * get item list
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [];
        
        try {
            $models = Item::orderBy('id', 'desc')->get();
            
            foreach ($models as $model) {
                $data[] = $model->getAttributes();
            }
        } catch (Exception $ex) {
            return response()->json($this->errorResponse('Error while items loaded', [$ex->getMessage()]));
        }
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }
  
    
    /**
     * Add item to list
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Item::$rules);

        if ($validator->fails()) {
            return response()->json($this->errorResponse('Incorrect input data', $validator->errors()->all()));
        }

        try {
            $model = Item::create($request->all());
        } catch (Exception $ex) {
            return response()->json($this->errorResponse('Error while item create', [$ex->getMessage()]));
        }
  
        if (empty($model)) {
            return response()->json($this->errorResponse('Can\'t item create', ['unknown error']));
        }
        
        return response()->json([
            'status' => true,
            'data' => $model->getAttributes(),
        ]);
    }
  
    
    /**
     * Delete item from list
     *
     * @param Request $request
     * @param int $itemId
     * @return Response
     */
    public function destroy(Request $request, $itemId)
    {
        if (!empty($itemId) && is_integer($itemId) && $itemId > 0) {
            return response()->json($this->errorResponse('Incorrect input data', ['unsigned integer missed']));
        }

        try {
            $deleted = Item::destroy($itemId);
        } catch (Exception $ex) {
            return response()->json($this->errorResponse('Error while item destroing', [$ex->getMessage()]));
        }
        
        return response()->json([
            'status' => true,
            'data' => [
                'item has deleted' => (bool) $deleted,
            ],
        ]);
    }
    
    
    /**
     * Delete selected items from list
     *
     * @param Request $request
     * @return Response
     */
    public function removeSelected(Request $request)
    {
        $selected = $request->input('selected');
        
        if (empty($selected)) {
            return response()->json($this->errorResponse('Can\'t items delete', ['empty selected items list']));
        }
        
        if (!is_array($selected)) {
            return response()->json($this->errorResponse('Can\'t items delete', ['incorrect items list']));
        }
        
        try {
            $deleted = Item::whereIn('id', array_values($selected))->delete();
        } catch (Exception $ex) {
            return response()->json($this->errorResponse('Error while selected items destroing', [$ex->getMessage()]));
        }
        
        return response()->json([
            'status' => true,
            'data' => [
                'items have deleted' => $deleted,
            ],
        ]);
    }
    
    
    /**
     * Delete all items from list
     *
     * @param Request $request
     * @return Response
     */
    public function removeAll(Request $request)
    {
        try {
            $deleted = Item::whereNotNull('id')->delete();
        } catch (Exception $ex) {
            return response()->json($this->errorResponse('Error while all items destroing', [$ex->getMessage()]));
        }
        
        return response()->json([
            'status' => true,
            'data' => [
                'items have deleted' => $deleted,
            ],
        ]);
    }
}
