<?php

namespace App\Http\Controllers\Admin;

use App\Component;
use App\data_acquisition;
use App\data_input_title;
use App\Http\Controllers\Controller;
use App\User;
use Box\Spout\Common\Exception\InvalidArgumentException;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Common\Exception\UnsupportedTypeException;
use Box\Spout\Writer\Exception\WriterNotOpenedException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use Rap2hpoutre\FastExcel\FastExcel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AREReportController extends Controller
{
    public function index(Request $request)
    {
        $data = data_acquisition::select('id','data_input_title_id', 'component_id', 'description', 'location', 'user_id', 'is_publish', 'date', 'created_at')
            ->with(
                'files:table_id,file_path,is_approve',
                'data_input_title:id,title',
                'component:id,package_no,name_en'
            )
            ->when($request->package_id, function ($q) use ($request) {
                return $q->where('component_id', $request->package_id);
            })
            ->when($request->user_id, function ($q) use ($request) {
                return $q->where('user_id', $request->user_id);
            })
            ->when($request->from_date, function ($q) use ($request) {
                return $q->whereBetween('created_at', [$request->from_date, $request->to_date]);
            })
            ->latest()
            ->get();

        // Get All ARE
        $users = User::where('role', 14)->get();
        $packages = Component::select('id', 'package_no', 'name_en')->where('type_id', '!=', 1)->get();

        $search = [];
        $search[0] = $request->package_id;
        $search[1] = $request->user_id;
        $search[2] = $request->from_date;
        $search[3] = $request->to_date;
        $compact = compact('data', 'users', 'search','packages');
        return view('admin.are_reports.index', $compact);

    }

    /**
     * Export ARE Data Acquisition Report
     * @param Request $request
     * @return string|StreamedResponse
     * @throws IOException
     * @throws InvalidArgumentException
     * @throws UnsupportedTypeException
     * @throws WriterNotOpenedException
     */
    public function exportAREDataAcquisitionReport(Request $request)
    {

        $data = data_acquisition::select('id','data_input_title_id',
            'component_id', 'description',
            'location', 'user_id',
            'is_publish', 'date',
            'created_at')
            ->with('data_input_title:title',
                'component:id,package_no,name_en'
            )
            ->when($request->package_id, function ($q) use ($request) {
                return $q->where('component_id', $request->package_id);
            })
            ->when($request->user_id, function ($q) use ($request) {
                return $q->where('user_id', $request->user_id);
            })
            ->when($request->from_date, function ($q) use ($request) {
                return $q->whereBetween('created_at', [$request->from_date, $request->to_date]);
            })
            ->latest()
            ->get();

        $dataCollection = $this->getFormattedCollection($data);
        $fileName = $this->generateReportFileName($request->user_id);

        return (new FastExcel($dataCollection))->download($fileName);

    }

    /**
     * Get Excel Formatted Data
     * @param $data
     * @return Collection
     */
    private function getFormattedCollection($data): Collection
    {
        return collect($data)->map(function ($item) {
            return [
                'ID' => $item->id ?? "-",
                'Package No' => $item->component->package_no ?? "-",
                'Package Name' => $item->component->name_en ?? "-",
                'Title' => $item->component->name_en ?? "-",
                'Description' => $item->description ?? "-",
                'Location' => $item->location ?? "-",
                'Is Publish' => $item->is_publish ?? "-",
                'Status' => getDataAcquisitionStatus($item->is_publish),
                'Date' => dateFormatter($item->date),
                'Created At' => dateTimeFormatter($item->created_at)
            ];
        });
    }

    /**
     * Get ARE Report Sender Name Name
     * @param null $user_id
     * @return string
     */
    private function generateReportFileName($user_id = null): string
    {
        $fileName = 'ARE Data Acquisition Report - ' . now()->format('Y-m-d H:i:s');

        if (!blank($user_id) && $user_id!=0) {
            $user = User::find($user_id);
            $fileName = 'ARE Data Acquisition Report - ' . now()->format('Y-m-d H:i:s') . " - " . $user->name;
        }
        return $fileName . ".xlsx";
    }
}
