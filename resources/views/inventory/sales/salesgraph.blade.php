@extends('inventory/layout')
@section ('content')

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-info text-white mr-2">
                  <i class="mdi mdi-file-chart  menu-icon"></i>
                </span>Sales Graph
              </h3>
              
            </div>
<div class="row">
              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Sales chart</h4>
                    <input type="hidden" class="form-control"  name="deli_note_no" id="sinv1" value="{{ $sinv1 }}"  readonly >
                    <input type="hidden" class="form-control"  name="deli_note_no" id="sinv2" value="{{ $sinv2 }}"  readonly >
                    <input type="hidden" class="form-control"  name="deli_note_no" id="sinv3" value="{{ $sinv3 }}"  readonly >
                    <canvas id="areaChart" style="height:250px"></canvas>
                  </div>
                </div>
              </div>
             <!--  <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Doughnut chart</h4>
                    <canvas id="doughnutChart" style="height:250px"></canvas>
                  </div>
                </div>
              </div> -->
            </div>

            @stop