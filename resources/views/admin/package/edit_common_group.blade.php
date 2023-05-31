<div class="col-4">
    <div class="form-group">
      <label for="name_en">Indicative date of Invitation for Tender </label>
      <div class="input-group datepicker-box">
        <input name="invitation_for_tender_est"  class="form-control datepicker w-100" type="text" value="{{ $component->invitation_for_tender_est }}"  placeholder="YY-MM-DD"/>
      </div>
    </div>
    
  </div>
  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Actual date of Invitation for Tender </label>
      <div class="input-group datepicker-box">
        <input name="invitation_for_tender_act"  class="form-control datepicker w-100" type="text" value="{{ $component->invitation_for_tender_act }}" />
      </div>
    </div>
  </div>
  <div class="col-4"></div>
  
  <?--                                   New tab                  --?>
  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Indicative date of Invitation for Bid Submission/Opening </label>
      <div class="input-group datepicker-box">
        <input name="invitation_bid_indicative_submission_date"  class="form-control datepicker w-100" 
        value="{{ $component->invitation_bid_indicative_submission_date  }}"
        type="text" placeholder="YY-MM-DD" />
      </div>
    </div>
  </div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Actual date of Invitation for Bid Submission/Opening</label>
      <div class="input-group datepicker-box">
        <input name="invitation_bid_act_submission_date"  class="form-control datepicker w-100" 
        value="{{ $component->invitation_bid_act_submission_date  }}"
        type="text" placeholder="YY-MM-DD" />
      </div>
    </div>
  </div>
  <div class="col-4"></div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Actual Evaluation of Bid  </label>
      <div class="input-group datepicker-box">
        <input name="Actual_eva_bid_date"  class="form-control datepicker w-100" 
        value="{{ $component->Actual_eva_bid_date  }}"
        type="text" placeholder="YY-MM-DD" />
      </div>
    </div>
  </div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Approval of Evaluation Report</label>
      <div class="input-group datepicker-box">
        <input name="approve_eva_report_pd_date"  class="form-control datepicker w-100" 
        value="{{ $component->approve_eva_report_pd_date  }}"
        type="text" placeholder="YY-MM-DD" />
      </div>
    </div>
  </div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Issue Notification of Award </label>
      <div class="input-group datepicker-box">
        <input name="issue_notifi_award_date"  class="form-control datepicker w-100" 
        value="{{ $component->issue_notifi_award_date  }}"
        type="text" placeholder="YY-MM-DD" />
      </div>
    </div>
  </div>
<?-- ---------------------------End new input filed----------------------?>
  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Indicative date of Contract Signing </label>
      <div class="input-group datepicker-box">
        <input name="signing_of_contact_est"  class="form-control datepicker w-100" type="text" 
        value="{{ $component->signing_of_contact_est }}" />
      </div>
    </div>
  </div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Indicative Date of Contract Completion</label>
      <div class="input-group datepicker-box">
        <input name="complition_of_contact_est"  class="form-control datepicker w-100" type="text"  value="{{ $component->complition_of_contact_est }}" id="completion_date_est" />
      </div>
    </div>
  </div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Completion Date</label>
      
      <div class="input-group datepicker-box">
        <input name="complition_date" 
          value="{{ $component->complition_date }}"
        class="form-control datepicker w-100" type="text" placeholder="YY-MM-DD" />    
      </div>
    </div>
  </div>