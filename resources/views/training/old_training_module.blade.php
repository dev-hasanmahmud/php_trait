@extends('layouts.master')
@section('content')
<div class="main-content mt-4 ">
    <section class="new-sec-1">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                <a href="{{ url('training-category') }}" class="card box" href="#">
                        <h4>Training Category</h4>
                        <span class="icons">

                        </span>
                    </a>
                </div>
                  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                    <a href="{{ url('training') }}" class="card box" href="#">
                        <h4>Training</h4>
                        <span class="icons">

                        </span>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 new-sec-box">
                    <a href="{{ url('training-activity') }}" class="card box" href="#">
                        <h4>Training Activities</h4>
                        <span class="icons">

                        </span>
                    </a>
                </div>
              
            <div class="table-responsive bg-white">
            <table class="report_1 table table-bordered report-table text-center">
              <thead>
                <tr>
                  <td><strong>SL.#</strong></td>
                  <td><strong>Sub-no.</strong></td>
                  <td><strong>Name of the Item</strong></td>
                  <td><strong>No. of total Training Events</strong></td>
                  <td><strong>No. of Total Training Batches</strong></td>
                  <td><strong>No. of total Training Events Actual</strong></td>
                  <td><strong>No. of Total Training Batches Actual</strong></td>
                </tr>
                
              </thead>
              <tbody>

                @foreach ($training_categories as $category)
                  <tr>
                  <td><strong>{{ $category->serial_no }}</strong></td>
                  <td colspan="3" class="text-left">
                    <strong> {{ $category->name }} </strong>
                  </td>
                  <td></td>
                 <td></td>
                 <td></td>
                 </tr>

                  @foreach ($trainings as $item)
                  @if ($item->training_category_id==$category->id)
                    <tr>
                    <td></td>
                    <td>{{ $item->serial_number }}</td>
                    <td><a href="{{ url('training-activity?training_id=')."$item->id" }}">{{ $item->title}}</a></td>
                    <td>{{ $item->total_event }}</td>
                    <td>{{ $item->toatal_batch }}</td>

                    @if (isset($training_activities[$item->id]))
                    <td>{{ $training_activities[$item->id]['number_of_event_act'] }}</td>
                    <td>{{ $training_activities[$item->id]['number_of_batch_act'] }}</td>
                    @endif

                      
                  </tr>
                  @endif
                  @endforeach
                @endforeach
  
              </tbody>
            </table>
          </div> 
            </div>
            <div class="print-show text-right mt-3">
                <a  href="{{ route('pdfview',['download'=>'pdf']) }}" class="btn btn-success btn-sm">
                <i class="fa fa-print" title="Download PDF"></i>
                </a>
            </div>
            <br>
        </div>
    </section>
</div>
@endsection
