@extends('inventory/layout')
@section ('content')
<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-home menu-icon "></i>
                </span>Dashboard 
              </h3>
              
            </div>
        
            <div class="row">
              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">{{session('exec')}}'s Total Revenue </h4>
                     @foreach($result as $res)
                    <input type="hidden" class="form-control"   id="amt{{$res->month}}" value="{{$res->sumamt}}"  readonly >
                     <input type="hidden" class="form-control"   id="profamt{{$res->month}}" value="{{$res->sumpsamt}}"  readonly >
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
                    <h4 class="card-title">{{session('exec')}}'s Total Profit </h4>
                    <canvas id="profitChart" style="height:250px"></canvas>
                  </div>
                </div>
              </div>
            </div>
        
<div class="row">
              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">{{session('exec')}}'s Revenue {{now()->format('M, Y')}}</h4>
                    
                    <canvas id="pieChart" style="height:250px"></canvas>
                  </div>
                </div>
              </div>
              
            </div>
            
         
            
@stop