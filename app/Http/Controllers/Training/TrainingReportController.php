<?php

namespace App\Http\Controllers\Training;
use DB;
use PDF;
use App\Training;
use App\TrainingCategory;
use App\Training_activity;
use Illuminate\Http\Request;
use App\Validator\validatorForm;
use App\Http\Controllers\Controller;

class TrainingReportController extends Controller
{
    use validatorForm;
   
    public function training_module()
    {
        $training_categories= TrainingCategory::orderBy('id', 'ASC')->get();
        $id = $training_categories->toArray();
        //return $id;
        $id = $training_categories[0]['id'];
        $training = DB::query()
        ->select(['train.*','at.*'])
        ->from('trainings as train')
        ->where('train.training_category_id','=',$id)
        ->leftJoinSub(function($query){
            $query->select(['ta.training_id', DB::raw( 'sum(ta.number_of_event) as number_of_event '),DB::raw( 'sum(ta.     number_of_batch) as number_of_batch ')])
                ->from('training_activities as ta')
                ->groupBy(['ta.training_id']);
            },'at','train.id','=','at.training_id')
        ->get();
        //return $training;
        return view('training.training_module',compact('training','training_categories'));
    }


    public function pdfview(Request $request)
    {
        $training_categories= TrainingCategory::orderBy('id', 'ASC')->get();
        $trainings= Training::orderBy('id', 'ASC')->get();
        $training_activities= Training_activity::orderBy('id', 'ASC')->get();

        view()->share('training_categories',$training_categories);
        view()->share('trainings',$trainings);
        view()->share('training_activities',$training_activities);

        if(($request->has('download')))
        {
            $pdf = PDF::loadView('exports.pdfview');
            return $pdf->download('training_report.pdf');
        }

    }
    public function details($id)
    {
        
        $training = DB::query()
        ->select(['train.*','at.*'])
        ->from('trainings as train')
        ->where('train.training_category_id','=',$id)
        ->leftJoinSub(function($query){
            $query->select(['ta.training_id', DB::raw( 'sum(ta.number_of_event) as number_of_event '),DB::raw( 'sum(ta.     number_of_batch) as number_of_batch ')])
                ->from('training_activities as ta')
                ->groupBy(['ta.training_id']);
            },'at','train.id','=','at.training_id')
        ->get();

        return $this->responseWithSuccess('Data Deleted successfully',$training);
    }

     /**old method for training module */
    /*
    public function training_module()
    {
        $training_categories= TrainingCategory::orderBy('id', 'ASC')->get();
        $trainings= Training::orderBy('id', 'ASC')->get();
        //$training_activities= Training_activity::orderBy('id', 'ASC')->get();
        $training_activities_query=DB::select(" SELECT training_id,SUM(number_of_event) AS number_of_event_act,SUM(number_of_batch) AS number_of_batch_act
        FROM training_activities
        GROUP BY training_id ");
        $training_activities=[];
        if($training_activities_query)
        {
            foreach($training_activities_query as $r)
            {
                $training_activities[$r->training_id]['number_of_event_act']=$r->number_of_event_act;
                $training_activities[$r->training_id]['number_of_batch_act']=$r->number_of_batch_act;
            }
        }


        return view('training.training_module',compact('training_categories','trainings','training_activities'));
    }
    */
}
