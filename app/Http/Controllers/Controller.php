<?php

namespace App\Http\Controllers;

use App\Models\Polymorphic\Connection;
use App\Models\Polymorphic\Image;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as facadesImage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function getResponse($message, $code = 200, $items = 0)
    {
        switch ($code) {
            case 200:
                $state = __('responseStatus.200');
                break;
            case 201:
                $state = __('responseStatus.201');
                break;
            case 304:
                $state = __('responseStatus.304');
                break;
            case 322:
                $state = __('Data Not complete');
                break;
            case 401:
                $state = __('responseStatus.401');
                break;
            case 404:
                $state = __('responseStatus.404');
                break;
            case 405:
                $state = __('responseStatus.405');
                break;
            case 422:
                $state = __('responseStatus.422');
                break;
            default:
                $state = __('responseStatus.0');
        }

        return response()->json([
            'status' => $state,
            'message' => $message,
            'payload' => $items
        ], $code);
    }

    public static function getResponseWithOutMessage($code = 200, $items = 0)
    {
        return response()->json([
            'payload' => $items
        ], $code);
    }

    public static function getPaginatedResopnse($message, $items, $perPage = 0, $page = null, $options = [])
    {
        $pageName = 'page';
        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ];

        if ($perPage == null || $perPage == 0) {
            $perPage = 10;
        }

        $page = $page ?: (Paginator::resolveCurrentPage($pageName) ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $data = new LengthAwarePaginator(
            $items->forPage($page, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            $options
        );

        return Controller::getResponse($message, 200, $data);
    }

    public static function uploadImage(Request $request, $fileName, $path)
    {
        $fileData = [];

        $fileData['original'] = $request->file('image');
        $fileData['fileType'] = $fileData['original']->getClientOriginalExtension();
        $fileData['path'] = $fileName . '.'
            . $fileData['fileType'];

        $fileData['file'] = Storage::putFileAs(
            $path,
            $fileData['original'],
            $fileData['path']
        );

        $image = new Image;

        $image->path = $fileData['file'];
        $image->hight = facadesImage::make($fileData['original'])->height();
        $image->width = facadesImage::make($fileData['original'])->width();

        return $image;
    }

    public static function fileURL($file)
    {
        $file = Storage::url($file);
        $file = asset($file);
        return $file;
    }

    public static function isExtensionAllowd($extension)
    {
        $default = [
            "JPEG",
            "JPG",
            "PNG",
        ];

        foreach ($default as $exe) {
            if (strtoupper($exe) == strtoupper($extension)) {
                return true;
            }
        }
        return false;
    }

    public static function createConnection($connectionTypeID, $value)
    {
        $connection = new Connection;
        $connection->value = $value;
        $connection->connectionTypeID = $connectionTypeID;

        return $connection;
    }

    public function removeConnection($connectionID)
    {
        $connection = Connection::find($connectionID);

        if (!$connection) {
            return parent::getResponse(
                __('connectionMessages.notFound'),
                404
            );
        }

        if (!$connection->delete()) {
            return parent::getResponse(
                __('connectionMessages.notDeleted'),
                404
            );
        }

        return parent::getResponse(
            __('connectionMessages.deleted'),
            200
        );
    }
}
