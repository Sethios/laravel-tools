<?php

namespace App\Http\Controllers;

use App\Models\¤ModelP¤;
use App\Http\Requests\¤ModelP¤Request;
use Exception;
use League\Csv\CharsetConverter;
use League\Csv\Reader;
use League\Csv\Writer;

class ¤ModelP¤Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the ¤ModelP¤ dashboard.
     *
     * @param \App\Models\¤ModelP¤ $¤modelC¤Model
     * @return \Illuminate\Contracts\Support\Renderable|JSON
     */
    public function index(¤ModelP¤ $¤modelC¤Model)
    {
        $¤modelsC¤ = $¤modelC¤Model::all();

        if (request()->ajax())
        {
            return compact('¤modelsC¤');
            $¤modelsC¤Json = $¤modelsC¤->map(function($¤modelC¤){
                return [
                    'id' => $¤modelC¤->id,
                    'name' => $¤modelC¤->name,
                    //
                    'actions' => view('¤modelC¤.partials.actions', ['¤modelC¤' => $¤modelC¤])->render(),
                ];
            });
            return json_encode(['data' => $¤modelsC¤Json]);
        }
        else
        {
            return view('¤modelC¤.index', compact('¤modelsC¤'));
        }
    }

    /**
     * Show the ¤ModelP¤ creation page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function new()
    {
        $¤modelC¤ = new ¤ModelP¤;

        if (request()->ajax())
        {
            return view('¤modelC¤.partials.inputs', ['¤modelC¤' => $¤modelC¤])->render();
        }
        else
        {
            return view('¤modelC¤.new', compact('¤modelC¤'));
        }
    }

    /**
     * Show the ¤ModelP¤ editing page.
     *
     * @param \App\Models\¤ModelP¤ $¤modelC¤Model
     * @param \App\Http\Requests\¤ModelP¤Request $¤modelC¤Request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(¤ModelP¤ $¤modelC¤Model, ¤ModelP¤Request $¤modelC¤Request)
    {
        $¤modelC¤ = $¤modelC¤Model->where('id', $¤modelC¤Request->get('¤_model¤_id'))->first();

        if (request()->ajax())
        {
            return view('¤modelC¤.partials.inputs', ['¤modelC¤' => $¤modelC¤])->render();
        }
        else
        {
            return view('¤modelC¤.edit', compact('¤modelC¤'));
        }
    }

    /**
     * Update 
     *
     * @param \App\Http\Requests\¤ModelP¤Request $¤modelC¤Request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(¤ModelP¤Request $¤modelC¤Request)
    {
        $¤modelC¤ = $this->upload¤ModelP¤Data($¤modelC¤Request);

        if (request()->ajax())
        {
            return json_encode([
                'status' => trans('¤_model¤.controller.update'),
                'modelData' => $¤modelC¤
            ]);
        }
        else
        {
            return redirect()->route('¤_model¤.index')->with('status', trans('¤_model¤.controller.update'));
        }
    }

    /**
     * Save the new ¤ModelP¤ in the database
     *
     * @param \App\Http\Requests\¤ModelP¤Request $¤modelC¤Request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(¤ModelP¤Request $¤modelC¤Request)
    {
        $¤modelC¤ = $this->upload¤ModelP¤Data($¤modelC¤Request);

        if (request()->ajax())
        {
            return json_encode([
                'status' => trans('¤_model¤.controller.store'),
                'modelData' => $¤modelC¤
            ]);
        }
        else
        {
            return redirect()->route('¤_model¤.index')->with('status', trans('¤_model¤.controller.store'));
        }
    }

    /**
     * Parse request data 
     * 
     * @param \App\Http\Requests\¤ModelP¤Request $requestData
     */
    private function upload¤ModelP¤Data($requestData)
    {
        $data = $requestData->except(['_token', '_method']);
        $method = $requestData->method();

        $data_secondary = [
            //
        ];

        $dataArray = array_merge($data, $data_secondary);

        switch ($method) {
            case "PATCH":
                // $¤_model¤ = ¤ModelP¤::findByAction($data['id'], $dataArray, $method);
                $¤_model¤ = ¤ModelP¤::find($data['id']);
                $¤_model¤->fill($dataArray);
                $¤_model¤->update();
                break;
            case "PUT":
                // $¤_model¤ = ¤ModelP¤::findByAction($data['unique_column'], $dataArray, $method);
                $¤_model¤ = ¤ModelP¤::create($dataArray);
                break;
            default:
                throw new Exception();
                break;
        }

        return $¤_model¤;
    }

    /**
     * Delete ¤ModelP¤ by ID
     *
     * @param \App\Models\¤ModelP¤ $¤modelC¤Model
     * @param \App\Http\Requests\¤ModelP¤Request $¤modelC¤Request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(¤ModelP¤ $¤modelC¤Model,¤ModelP¤Request $¤modelC¤Request)
    {
        $id = $¤modelC¤Model->find($¤modelC¤Request->get('¤_model¤_id'));
        $id->delete();

        if (request()->ajax())
        {
            return json_encode(['status' => trans('¤_model¤.controller.delete')]);
        }
        else
        {
            return redirect()->route('¤_model¤.index')->with('status', trans('¤_model¤.controller.delete'));
        }
    }

    /**
     * Import page view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function import(¤ModelP¤ $¤modelC¤Model)
    {
        if (request()->ajax())
        {
            return '';
        }
        else
        {
            return view('¤modelC¤.import');
        }
    }

    /**
     * Import data from a CSV file
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function importSave(¤ModelP¤ $¤modelC¤Model, ¤ModelP¤Request $¤modelC¤Request)
    {
        $file_name = $¤modelC¤Request->file('importFile')->getRealPath();
        $csv = Reader::createFromPath($file_name);
        $csv->setOutputBOM(Reader::BOM_UTF8);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        foreach ($records as $offset => $record) {
            $record = array_values($record);

            switch($¤modelC¤Request->get('method')) {
                case 'utf': $converted_string = fix_croatian_letters($record[0]); break;
                case 'w1250': $converted_string = w1250_to_utf8($record[0]); break;
                default: $converted_string = $record[0]; break;
            }

            $record_array = [
                'id' => $record[0],
                //
            ];
            $¤modelC = $¤modelC¤Model->updateOrCreate(['id' => $record[0]], $record_array);
        }
        return redirect()->route('¤modelC.index')->with('status', trans('¤_model¤.controller.imported'));
    }

    /**
     * Download data as CSV
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function download(¤ModelP¤ $¤modelC¤Model, ¤ModelP¤Request $¤modelC¤Request)
    {
        $¤modelsC = $¤modelC¤Model->get¤ModelP¤sByUsers($¤modelC¤Request->get('id'));

        $encoder = (new CharsetConverter())
            ->inputEncoding('UTF-8')
            ->outputEncoding('UTF-8');
        $csv = Writer::createFromFileObject(new \SplTempFileObject);
        $csv->setOutputBOM(Writer::BOM_UTF8);
        $csv->setDelimiter(';');
        $csv->addFormatter($encoder);
        $csv->insertOne([
            'ID',
            //
        ]);

        $csv_array = [];
        foreach ($¤modelsC as $¤modelC) {
            $csv_array[] = [
                $¤modelC->id,
                //
            ];
        }
        $csv->insertAll($csv_array);

        return response((string) $csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Disposition' => 'attachment; filename="¤modelsC.csv"',
        ]);
    }
}
