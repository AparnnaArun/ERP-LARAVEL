@extends('admin/layout')
@section ('content')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-home menu-icon "></i>
                </span>Dashboard 
              </h3>
              
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
            <div class="row">
              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Total Revenue </h4>
                    @foreach($result as $res)
                    <input type="hidden" class="form-control"   id="amt{{$res->month}}" value="{{$res->sumamt}}"  readonly >
                     <input type="hidden" class="form-control"   id="profamt{{$res->month}}" value="{{$res->sumprof}}"  readonly >
                    <input type="hidden" class="form-control"   id="month{{$res->month}}" value="{{$res->month}}"  readonly >
                    @endforeach
                    @foreach($result1 as $res1)
                    <input type="hidden" class="form-control"   id="pamt{{$res1->month}}" value="{{$res1->sumpamt}}"  readonly >
                    <input type="hidden" class="form-control"   id="pmonth{{$res1->month}}" value="{{$res1->month}}"  readonly >
                    @endforeach
                     @foreach($result2 as $res2)
                    <input type="hidden" class="form-control"   id="examt{{$res2->month}}" value="{{$res2->sumepamt}}"  readonly >
                    <input type="hidden" class="form-control"   id="exmonth{{$res2->month}}" value="{{$res2->month}}"  readonly >
                    @endforeach
                    @foreach($result3 as $res3)
                    <input type="hidden" class="form-control"   id="cmamt{{$res3->month}}" value="{{$res3->sumcpamt}}"  readonly >
                    
                    @endforeach
                    @foreach($result4 as $res4)
                    <input type="hidden" class="form-control"   id="csamt{{$res4->month}}" value="{{$res4->sumcsamt}}"  readonly >
                    
                    @endforeach
                  
                    <canvas id="barChart" style="height:250px"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Total Profit </h4>
                    <canvas id="profitChart" style="height:250px"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
               <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Revenue {{now()->format('M, Y')}} </h4>
                    <canvas id="pieChart" style="height:250px"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 grid-margin stretch-card">
                 <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Revenue </h4>
                <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required">Month</span>
                        </div>
                        
                        <select class="form-control cmonth"  name="month" >
                          <option value="" hidden>Month</option>
                        
                          <option value="01" >Jan</option>
                        <option value="02" >Feb</option>
                        <option value="03" >March</option>
                        <option value="04" >Apr</option>
                        <option value="05" >May</option>
                        <option value="06" >Jun</option>
                        <option value="07" >July</option>
                        <option value="08" >Aug</option>
                        <option value="09" >Sep</option>
                        <option value="10" >Oct</option>
                        <option value="11" >Nov</option>
                        <option value="12" >Dec</option>
                        </select>
                        <div class="resultss">
                        
                      </div>
                    </div>
                    </div>
              <canvas id="barChart1" style="height:250px"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
               <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"> Executive Revenue As On </h4>
                    <div class="row">
                    <div class="col-lg-10 grid-margin stretch-card">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text bg-gradient-info text-white required">Date</span>
                        </div>
                        
                        <input type="text" class="form-control datepicker "  name="month" />
                          
                        <div class="resultsss">
                        
                      </div>
                    </div>
                    </div>
                  </div>
                   <div class="col-sm-2 grid-margin">
                    <button type="button"  class="btn btn-gradient-info btn-xs go">Go</button>
                   </div>
                 </div>
                    <canvas id="barChart2" style="height:250px"></canvas>
                  </div>
                </div>
              </div>
            </div>
 <script src="../../assets/js/jquery-3.6.0.min.js"></script>           
  <script type="text/javascript">
    $(".cmonth").change(function(){
               month = $(this).val();
               token = $("#token").val();
              $.ajax({
         type: "POST",
         url: "{{url('getsumvalue')}}", 
         data: {_token: token,month:month},
         dataType: "html",  
         success: 
              function(data){
              //alert(data);
$(".resultss").html(data);
var cnt =$("#cnt").val();

var sin1AIJU =$('#sin1'+'AIJU').val();
var sin1JOBY =$('#sin1'+'JOBY').val();
var sin1jolly =$('#sin1'+'JOLLY').val();
 var sin1shebu =$('#sin1'+'SHEBU').val();
 var sin1VIDYA =$('#sin1'+'VIDYA').val();
var pinvsAIJU =$('#pinvs'+'AIJU').val();
var pinvsJOBY =$('#pinvs'+'JOBY').val();
var pinvsjolly =$('#pinvs'+'JOLLY').val();
 var pinvsshebu =$('#pinvs'+'SHEBU').val();
 var pinvsVIDYA =$('#pinvs'+'VIDYA').val();
//alert(sin1shebu);
 var databar = {
    labels: ["AIJU","JOBY","JOLLY","SHEBU","VIDYA"],
    datasets: [{
      label: 'Sales Revenue in KWD',
      data: [sin1AIJU,sin1JOBY,sin1jolly,sin1shebu,sin1VIDYA],
      backgroundColor: 
        'rgba(750, 150, 150, 0.5)',
      borderColor: 
        'rgba(750, 150, 150, 0.5)',
        },{
      label: 'Project Revenue in KWD',
      data: [pinvsAIJU,pinvsJOBY,pinvsjolly,pinvsshebu,pinvsVIDYA],
       backgroundColor: 'maroon',
borderColor: 'maroon',
        },]
  };
  var   options = {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: false
        },
        stacked:true,
      }],
       xAxes: [{
       stacked:true
      }],
    },
    legend: {
      display: true
    },
    elements: {
      point: {
        radius: 1.4
      }
    },
 plugins: {
      datalabels: {
        anchor: 'end',
        align: 'top',
        formatter: Math.round,
        font: {
          weight: 'bold'
        }
      }
    }
  };
if ($("#barChart1").length) {
    var barChartCanvas1 = $("#barChart1").get(0).getContext("2d");
  
    var barChart1 = new Chart(barChartCanvas1, {
      type: 'bar',
      data: databar,
      options: options
    });
  }
              }
          });

                })
    //////DAte As on Report////////////////////
      $(".go").click(function(){
               dates = $(".datepicker").val();
               token = $("#token").val();
               //alert(dates);
              $.ajax({
         type: "POST",
         url: "{{url('getallexceprofvalue')}}", 
         data: {_token: token,dates:dates},
         dataType: "html",  
         success: 
              function(data){
              //alert(data);
$(".resultsss").html(data);
var sasAIJU =$('#sas'+'AIJU').val();
var sasJOBY =$('#sas'+'JOBY').val();
var sasjolly =$('#sas'+'JOLLY').val();
 var sasshebu =$('#sas'+'SHEBU').val();
 var sasVIDYA =$('#sas'+'VIDYA').val();
var pasAIJU =$('#pas'+'AIJU').val();
var pasJOBY =$('#pas'+'JOBY').val();
var pasjolly =$('#pas'+'JOLLY').val();
 var passhebu =$('#pas'+'SHEBU').val();
 var pasVIDYA =$('#pas'+'VIDYA').val();
 exec ="";
 $("td input.pas").each(function() {
   exec += $(this).val();
  });

//alert(exec);
 var databar2 = {
    labels: [exec],
    datasets: [{
      label: 'Sales Revenue in KWD',
      data: [sasAIJU,sasJOBY,sasjolly,sasshebu,sasVIDYA],
      backgroundColor: 
        'rgba(750, 150, 150, 0.5)',
      borderColor: 
        'rgba(750, 150, 150, 0.5)',
        },{
      label: 'Project Revenue in KWD',
      data: [pasAIJU,pasJOBY,pasjolly,passhebu,pasVIDYA],
       backgroundColor: 'maroon',
borderColor: 'maroon',
        },]
  };
  var   options = {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: false
        },stacked:true,
      }],
       xAxes: [{
       stacked:true
      }],
    },
    legend: {
      display: true
    },
    elements: {
      point: {
        radius: 1.4
      }
    },
 plugins: {
      datalabels: {
        anchor: 'end',
        align: 'top',
        formatter: Math.round,
        font: {
          weight: 'bold'
        }
      }
    }
  };
if ($("#barChart2").length) {
    var barChartCanvas2 = $("#barChart2").get(0).getContext("2d");
  
    var barChart2 = new Chart(barChartCanvas2, {
      type: 'bar',
      data: databar2,
      options: options
    });
  }
              }
          });

                })
  </script>          
@stop