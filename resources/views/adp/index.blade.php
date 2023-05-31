@extends('layouts.master')
@section('content')

<div class="main-content form-component mt-4 ">
      <div class="container">
        @include('sweetalert::alert')
        <div class="card mb-4 card-design">
          <div class="card-body">
            <div class="card-title bg-primary text-white">
              <h5>ADP Report Template </h5>
            </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Template: </label>
                    <div class="col-sm-9" id="file_group">
                      <div class="float-sm-left mr-2 ml-0">
                        <div>
                          <a id="btnToggUp"    class="btn btn-outline-success at-aglance-button" id="add_file"> View and Download Template for ADP Report <i class="fa fa-bars" aria-hidden="true"></i></a>
                        </div>
                
                       </div>
                    </div>
                </div>

                {{-- start modal --}}
                <div class="modal fade slide-up glance-tbl" id="ataGlanceSlideUp" tabindex="-1" role="dialog" aria-hidden="false" style="overflow-x:scroll;">
											<div class="modal-dialog" style="width:90%; max-width:90%;">
												<div class="modal-content-wrapper">
													<div class="modal-content">
														<div class="modal-header clearfix text-left">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-20"></i></button>
															<h5 class="m-t-0 m-b-0"><span class="semi-bold tit-co"></span></h5>

														</div>
														<div class="modal-body" id="at-a-glance">
														
														</div>
													</div>
												</div>
											</div>
                  </div>
                  {{-- end modal --}}
          </div>
        </div>
      </div>
    </div>
@endsection


@push('script')

<script>
     
function change_file(file_id){
    console.log('preview file start'+file_id)
    $('#file_'+file_id).change(function(e){
        console.log(this.files[0].name)
        html=`<p> ${this.files[0].name}</p>`
        $('#file_preview_container_'+file_id).html(html)
    });
}
</script>
 <script>
    $('#btnToggUp').click(function() {
      
            var size = $('input[name=slideup_toggler]:checked').val()
            var modalElem = $('#ataGlanceSlideUp');
            if (size == "mini") {
                $('#ataGlanceSlideUpUpLarge').modal('show')
            } else {
                $('#ataGlanceSlideUp').modal('show')
                if (size == "default") {
                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                } else if (size == "full") {
                    modalElem.children('.modal-dialog').addClass('modal-lg');
                }
            }
        });
 </script>
 <script>
   	$('.at-aglance-button').click(function(){
		
				$.ajax({
					type: "get",
					url: "{{ url('ajax/get-formate-adp-report-template') }}",
				}).done(function(resp) {
					$("#at-a-glance").html(resp);
				});
		});
		
 </script>
    
@endpush