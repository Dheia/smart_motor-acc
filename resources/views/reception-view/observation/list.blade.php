@extends('layouts.app')
@section('content')
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Observation library',$userid)=='yes')
<div class="right_col" role="main">
   <div class="">
      <div class="page-title">
         <div class="nav_menu">
            <nav>
               <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Observation')}}</span></a>
               </div>
               @include('dashboard.profile')
            </nav>
         </div>
      </div>
      @if(session('message'))
      <div class="row massage">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="checkbox checkbox-success checkbox-circle">
               <label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}  </label>
            </div>
         </div>
      </div>
      @endif
      <div class="row" >
         <div class="col-md-12 col-sm-12 col-xs-12" >
            <div class="x_content">
               <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
                  <li role="presentation" class="active suppo_llng_li floattab"><a href="{!! url('/observation/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Observation List')}}</b></a></li>
                  <li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('/observation/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add Observation')}}</a></li>
               </ul>
            </div>
            <div class="x_panel table_up_div">
               <div class="panel-heading addpoint">
                  @if(!empty($check_data))
                  @foreach($check_data as $check_datas)
                  <div class="panel-group" id="accordion1">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo-<?php echo $check_datas->vehicle_id ?>" class="emailacordin"><i class="plus-minus glyphicon glyphicon-plus"> </i> 
                              @if($check_datas->vehicle_id == '0')
                              {{ 'General' }}
                              @else
                              {{ getVehicleName($check_datas->vehicle_id) }} </a> 
                              @endif
                              </a>
                           </h4>
                        </div>
                        <div id="collapseTwo-<?php echo $check_datas->vehicle_id ?>" class="panel-collapse collapse inplus">
                           <div class="panel-body">
                              <!-- Here we insert another nested accordion -->
                              <div class="panel-group" id="accordion2">
                                 <div class="panel panel-default">
                                    <?php
                                       $vehiclepopints = Getvehiclecheckpoint($check_datas->vehicle_id); 
                                       
                                   foreach($vehiclepopints as $vehiclepopintss)
                                    { ?>
                                    <div class="panel-heading">
                                       <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion2" href="#collapseInnerTwo-<?php echo $vehiclepopintss->id ?>" class="emailacordin plsmins<?php echo $vehiclepopintss->id ?>"><i class="plus-minus glyphicon glyphicon-plus"> </i>
                                          {{ $vehiclepopintss->checkout_point}} </a> 
                                          </a>
                                       </h4>
                                    </div>
                                    <div id="collapseInnerTwo-<?php echo $vehiclepopintss->id ?>" class="panel-collapse collapse inplus">
                                       <div class="panel-body">
                                          <div class="form-group">
                                             <table class="table table-striped">
                                                <thead>
                                                   <tr>
                                                      <td><b>#</b></td>
                                                      <td><b>{{ trans('app.Checkpoints')}}</b></td>
                                                      <td><b>{{ trans('app.Action')}}</b></td>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <?php
                                                      $i = 1;   
                                                      $subcategory =getCheckPointSubCategory($vehiclepopintss->checkout_point,$check_datas->vehicle_id); 
                                                        if(!empty($subcategory))
                                                        {
                                                      	foreach($subcategory as $subcategorys)
                                                        { ?>
                                                   <tr class="id{{ $subcategorys->checkout_point }}">
                                                      <td><?php echo $i++; ?></td>
                                                      <td class="row{{ $subcategorys->checkout_point }}">
                                                         <?php echo $subcategorys->checkout_point.'<br>';
                                                            ?>
                                                      </td>
                                                      <td> 
                                                         <button type="button" class="btn btn-round btn-success btn_edit" data-toggle="modal" data-target="#updateform" edit_id="{{ $subcategorys->id }}" > {{ trans('app.Edit')}} </button></a>
                                                         <a url="{{ url('/observation/deleteuser/') }}"> <button type="button" class="btn btn-round btn-danger btn_del dgr1" data-id="{{ $subcategorys->id }}" >{{ trans('app.Delete')}}</button></a>
                                                      </td>
                                                   </tr>
                                                   <?php   }
                                                      }
                                                      ?>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    </div>
									<script>
									$(document).ready(function(){
										var i = 0;
										$('.plsmins{{$vehiclepopintss->id}}').click(function(){
											i = i+1;
											if(i%2!=0){
												$(this).parent().find(".glyphicon-plus:first").removeClass("glyphicon-plus").addClass("glyphicon-minus");
											}else{
												$(this).parent().find(".glyphicon-minus:first").removeClass("glyphicon-minus").addClass("glyphicon-plus");
											}
										});
									});
									</script>
                                    <?php 
                                       }
                                       ?>
                                 </div>
                              </div>
                              <!-- Inner accordion ends here -->
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@else
<div class="right_col" role="main">
   <div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
      <div class="nav toggle" style="padding-bottom:16px;">
         <span class="titleup">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
      </div>
   </div>
</div>
@endif   
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- /page content -->
<script>
   $(document).ready(function(){
        $('.btn_del').click(function(){
    
      var url =  "<?php echo url('/deleteuser'); ?>";
      var id = $(this).attr('data-id');
      
   swal({   
             title: "Are You Sure?",
   	text: "You will not be able to recover this data afterwards!",   
             type: "warning",   
             showCancelButton: true,   
             confirmButtonColor: "#297FCA",   
             confirmButtonText: "Yes, delete!",   
             closeOnConfirm: false 
         }, function(){
   
             $.ajax({
                type:'get',
                url:url,
                data:{id:id},
   	   
                success:function(data){
   		   
   		$('.cancel').trigger( "click" );
   		
   		window.location.href ='{{ url('observation/list')}}';
   		
                 },
                 });
              
         });
         });
   });
   
</script>
<!-- Modal for edit category -->
<div id="updateform" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">{{ trans('app.Edit Chekpoint')}}</h4>
            <!-- <button type="button" id="add_new_check" class="btn btn-default add_field_button" style="float: right;" >Add New</button> -->
         </div>
         <div class="modal-body">
            
         </div>
         <div class="modal-footer" style="border-top:none; text-align: center;">
            <button  class="btn btn-success submit_edit">{{ trans('app.Update')}}</button>
         </div>
      </div>
   </div>
</div>
<script>
    $(document).ready(function(){
		
     $('.btn_edit').click(function(){
   
       var url = "<?php echo url('/editcheckpoin'); ?>"
       var id = $(this).attr('edit_id');
   	
   
       $.ajax({ 
           type:'GET',
           url:url,
           data:{ id:id },
   
           success:function(response)
           {
   		
   		$('.modal-body').html(response.html);
                       
           },
           error:function()
           {
             alert("Somthing went wrong..!");
           }
       });
     
     });
   
   $('body').on('click','.submit_edit',function(){
   
       var url = "<?php echo url('/submitnewname'); ?>"
       var id = $('.check_point_id').val();
       var subpoints = $("input[name='checkpoint[]']")
                 .map(function(){return $(this).val();}).get(); 
   	
   	
       $('.modal').modal('hide');
       $.ajax({ 
           
           type:'GET', 
           url:url,
           data:{ id:id,subpoints:subpoints},
           success:function(response)
           { 
   		
   			window.location.href = '{{ url('observation/list')}}';
           },
           
       });
     
     });
   
   });  
   
</script>
<script>
   $(document).ready(function() {
   	
   var max_fields = 20; //maximum input boxes allowed
   var wrapper = $(".items"); //Fields wrapper
   var add_button = $(".add_field_button"); //Add button ID
    
   var x = 1; //initlal text box count
   $('body').on('click','.add_field_button',function(e){
   
   //$(add_button).click(function(e){ //on add input button click
   
   e.preventDefault();
   if(x < max_fields){ //max input box allowed
   x++; 
   $(wrapper).append('<div class="form-group"><label class="control-label col-md-4 col-sm-3 col-xs-12">{{ trans('app.Check Point') }}<label class="text-danger">&nbsp;&nbsp;*</label></label>' +
   '<input class="form-control col-md-7 col-xs-12" idid="chek_pt" type="text" placeholder="{{ trans('app.Enter Checkpoint Name')}}" name="checkpoint[]" style="width:48% !important;"/>' + '&nbsp;&nbsp;'+'<a href="#" class="remove_field"><i class="fa fa-times" style="margin-top:10px !important;"></a></div>'); 
   }
   });
    
   $(wrapper).on("click",".remove_field", function(e){ 
   e.preventDefault(); $(this).parent('div').remove(); x--;
   })
   });
</script>

<script>
   $(function() {
    
     function toggleIcon(e) {
         $(e.target)
             .prev('.panel-heading')
             .find(".plus-minus")
             .toggleClass('glyphicon-plus glyphicon-minus');
     }
     $('.panel-group').on('hidden.bs.collapse', toggleIcon);
     $('.panel-group').on('shown.bs.collapse', toggleIcon);
    
   });
</script>	
@endsection