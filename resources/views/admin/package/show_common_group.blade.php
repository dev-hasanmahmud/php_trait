<div class="col-4">
    <div class="form-group">
         <label for="name_en">Indicative date of Invitation for Tender </label>
        <h4>{{ $component->invitation_for_tender_est }}</h4>
    </div>
    
  </div>
  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Actual date of Invitation for Tender </label>
        <h4>{{ $component->invitation_for_tender_act }}</h4>
    </div>
  </div>
  <div class="col-4"></div>
  
  <?--                                   New tab                  --?>
  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Indicative date of Invitation for Bid Submission/Opening </label>
      <h4>{{ $component->invitation_bid_indicative_submission_date }}</h4>
    </div>
  </div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Actual date of Invitation for Bid Submission/Opening</label>
      <h4>{{ $component->invitation_bid_act_submission_date }}</h4>
    </div>
  </div>
  <div class="col-4"></div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Actual Evaluation of Bid  </label>
      <h4>{{ $component->Actual_eva_bid_date }}</h4>
    </div>
  </div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Approval of Evaluation Report</label>
      <h4>{{ $component->approve_eva_report_pd_date }}</h4>
    </div>
  </div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Issue Notification of Award </label>
      <h4>{{ $component->issue_notifi_award_date }}</h4>
    </div>
  </div>
<?-- ---------------------------End new input filed----------------------?>
  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Indicative date of Contract Signing </label>
      <h4>{{ $component->signing_of_contact_est }}</h4>
    </div>
  </div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Indicative Date of Contract Completion</label>
      <h4>{{ $component->complition_of_contact_est }}</h4>
    </div>
  </div>

  <div class="col-4">
    <div class="form-group">
      <label for="exampleInputEmail1">Completion Date</label>
      <h4>{{ $component->complition_date }}</h4>
    </div>
  </div>