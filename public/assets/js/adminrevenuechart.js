$(function () {
  /* ChartJS
   * -------
   * Data and config for chartjs
   */
   var d = new Date();
var n = d.getMonth();
    nn =parseFloat(n)+1;
     ncmt ='cmamt'+nn;
 
var amt1 =$("#amt1").val();
var amt2 =$("#amt2").val();
var amt3 =$("#amt3").val();
var amt4 =$("#amt4").val();
var amt5 =$("#amt5").val();
var amt6 =$("#amt6").val();
var amt7 =$("#amt7").val();
var amt8 =$("#amt8").val();
var amt9 =$("#amt9").val();
var amt10 =$("#amt10").val();
var amt11=$("#amt11").val();
var amt12=$("#amt12").val();
var pamt1 =$("#pamt1").val();
var pamt2 =$("#pamt2").val();
var pamt3 =$("#pamt3").val();
var pamt4 =$("#pamt4").val();
var pamt5 =$("#pamt5").val();
var pamt6 =$("#pamt6").val();
var pamt7 =$("#pamt7").val();
var pamt8 =$("#pamt8").val();
var pamt9 =$("#pamt9").val();
var pamt10 =$("#pamt10").val();
var pamt11=$("#pamt11").val();
var pamt12=$("#pamt12").val();
var examt1 =$("#examt1").val();
var examt2 =$("#examt2").val();
var examt3 =$("#examt3").val();
var examt4 =$("#examt4").val();
var examt5 =$("#examt5").val();
var examt6 =$("#examt6").val();
var examt7 =$("#examt7").val();
var examt8 =$("#examt8").val();
var examt9 =$("#examt9").val();
var examt10 =$("#examt10").val();
var examt11=$("#examt11").val();
var examt12=$("#examt12").val();
var profamt1 =$("#profamt1").val();
var profamt2 =$("#profamt2").val();
var profamt3 =$("#profamt3").val();
var profamt4 =$("#profamt4").val();
var profamt5 =$("#profamt5").val();
var profamt6 =$("#profamt6").val();
var profamt7 =$("#profamt7").val();
var profamt8 =$("#profamt8").val();
var profamt9 =$("#profamt9").val();
var profamt10 =$("#profamt10").val();
var profamt11=$("#profamt11").val();
var profamt12=$("#profamt12").val();
var cmamts  =$('#cmamt'+nn).val();
var csamts =$('#csamt'+nn).val();
if (typeof pamt1 == 'undefined'){
  var pamt1 =0;
 
}
if (typeof pamt2 == 'undefined'){
  var pamt2 =0;
 
}
if (typeof pamt3 == 'undefined'){
  var pamt3 =0;
 
}
if (typeof pamt4 == 'undefined'){
  var pamt4 =0;
 
}
if (typeof pamt5 == 'undefined'){
  var pamt5 =0;
 
}
if (typeof pamt6 == 'undefined'){
  var pamt6 =0;
 
}
if (typeof pamt7 == 'undefined'){
  var pamt7 =0;
 
}
if (typeof pamt8 == 'undefined'){
  var pamt8 =0;
 
}
if (typeof pamt9 == 'undefined'){
  var pamt9 =0;
 
}
if (typeof pamt10 == 'undefined'){
  var pamt10 =0;
 
}
if (typeof pamt11 == 'undefined'){
  var pamt11 =0;
 
}
if (typeof pamt12 == 'undefined'){
  var pamt12 =0;
 
}
if (typeof examt1 == 'undefined'){
  var examt1 =0;
 
}
if (typeof examt2 == 'undefined'){
  var examt2 =0;
 
}
if (typeof examt3 == 'undefined'){
  var examt3 =0;
 
}
if (typeof examt4 == 'undefined'){
  var examt4 =0;
 
}
if (typeof examt5 == 'undefined'){
  var examt5 =0;
 
}
if (typeof examt6 == 'undefined'){
  var examt6 =0;
 
}
if (typeof examt7 == 'undefined'){
  var examt7 =0;
 
}
if (typeof examt8 == 'undefined'){
  var examt8 =0;
 
}
if (typeof examt9 == 'undefined'){
  var examt9 =0;
 
}
if (typeof examt10 == 'undefined'){
  var examt10 =0;
 
}
if (typeof examt11 == 'undefined'){
  var examt11 =0;
 
}
if (typeof examt12 == 'undefined'){
  var examt12 =0;
 
}
var proprof1 =(pamt1-examt1);
var proprof2 =(pamt2-examt2);
var proprof3= (pamt3-examt3);
var proprof4=(pamt4-examt4);
var proprof5 =(pamt5-examt5);
var proprof6=(pamt6-examt6);
var proprof7=(pamt7-examt7);
var proprof8=(pamt8-examt8);
var proprof9=(pamt9-examt9);
var proprof10=(pamt10-examt10);
var proprof11=(pamt11-examt11);
var proprof12=(pamt12-examt12);
//alert(examt7);
  'use strict';
  var data = {
    labels: ["Jan", "Feb", "March", "April", "May", "June",
  "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
    datasets: [{
      label: 'Sales Revenue in KWD',
      data: [amt1, amt2, amt3,amt4,amt5,amt6,amt7,amt8,amt9,amt10,amt11,amt12],
      backgroundColor: 
        '#40E0D0',
      borderColor: 
        '#40E0D0',
        
      
     
    },
    
    {label: 'Project Revenue in KWD',
      data: [pamt1, pamt2, pamt3,pamt4,pamt5,pamt6,pamt7,pamt8,pamt9,pamt10,pamt11,pamt12],
 backgroundColor: '#DE3163',
borderColor: '#DE3163',

    }]
  };
 
var   options = {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }, stacked:true,
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
      title: {
        display: true,
        text: 'Chart.js Bar Chart - Stacked'
      },
    },
  };
    var dataprofit = {
    labels: ["Jan", "Feb", "March", "April", "May", "June",
  "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
    datasets: [{
      label: 'Sales Profit in KWD',
      data: [profamt1, profamt2, profamt3,profamt4,profamt5,profamt6,profamt7,profamt8,profamt9,profamt10,profamt11,profamt12],
      backgroundColor: 
        '#71D523',
      borderColor: 
        '#71D523',
        
      
     
    },{label: 'Project Profit in KWD',
      data: [proprof1,proprof2,proprof3,proprof4,proprof5,proprof6,proprof7,proprof8,
      proprof9,proprof10,proprof11,proprof12],
 backgroundColor: '#800080',
borderColor: '#800080',

    }]
  };
var   optionprofit = {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
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
   var doughnutPieData = {
    datasets: [{
      data: [cmamts,csamts],
      backgroundColor: [
        '#999999',
        '#BCD908',
        'rgba(255, 206, 86, 0.5)',
        'rgba(75, 192, 192, 0.5)',
        'rgba(153, 102, 255, 0.5)',
        'rgba(255, 159, 64, 0.5)'
      ],
      borderColor: [
        '#999999',
        '#BCD908',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
      'Project Revenue',
      'Sales Revenue',

    
    ]
  };
  var doughnutPieOptions = {
    responsive: true,
    animation: {
      animateScale: true,
      animateRotate: true
    }
  };
if ($("#barChart").length) {
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
  
    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: data,
      options: options
    });
  }
  if ($("#profitChart").length) {
    var profitChartCanvas = $("#profitChart").get(0).getContext("2d");
  
    var pChart = new Chart(profitChartCanvas, {
      type: 'bar',
      data: dataprofit,
      options: optionprofit
    });
  }
  if ($("#pieChart").length) {
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: doughnutPieData,
      options: doughnutPieOptions
    });
  }
 
 });