<?php

namespace App\Http\Controllers;

use App\File_manager;
use App\Validator\validatorForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileManagerController extends Controller
{

    use validatorForm;

    /**
     * @param $fileManagerId
     * @return BinaryFileResponse
     */
    public function downloadAttachment($fileManagerId): BinaryFileResponse
    {
        $fileManagerDataArray = $this->returnFileManagerData($fileManagerId);
        return Response::download($fileManagerDataArray['record']['file_path'], $fileManagerDataArray['newFileName']);
    }

    /**
     * @param $fileManagerId
     * @return BinaryFileResponse
     */
    public function viewAttachment($fileManagerId): BinaryFileResponse
    {
        $fileManagerDataArray = $this->returnFileManagerData($fileManagerId);
        return Response::file($fileManagerDataArray['record']['file_path'], $fileManagerDataArray['newFileName']);
    }

    /**
     * Return File Manager Record and File Name
     * @param $fileManagerId
     * @return array
     */
    private function returnFileManagerData($fileManagerId): array
    {
        $record = File_manager::where('id', $fileManagerId)->select('name', 'file_path')->firstOrFail();

        if (!File::exists($record->file_path)) {
            abort(404);
        }

        $splitFilePath = preg_split('/(-.-)/', $record->file_path);
        $fileManagerName = array_key_exists(1, $splitFilePath) ?
            $splitFilePath[1] :
            "Report File." . File::extension($record->file_path);

        return [
            'record' => $record->toArray(),
            'newFileName' => $record->name . " - " . $fileManagerName,
        ];
    }
}
