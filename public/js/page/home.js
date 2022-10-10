function randomColor(){  
  return '#'+(0x1000000+Math.random()*0xffffff).toString(16).substr(1,6);
}

if(sesMessage)
{
    show_toast(sesMessage, 'success');
}
var pieColors = ['#61ba61','#fa5c7c'];

var options = {
      	series: attendance,
      	chart: {
      	width: "100%",
      	type: 'pie',            
    },
    legend: {
        position: 'bottom'
    },
    colors: pieColors,
    labels: ['Attendance', 'Attendance Needed'],
    responsive: [{
      	breakpoint: 800,
      	options: {
        chart: {
        	width: 380
        },
        legend: {
         	position: 'bottom'
        }
      }
    }]
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();

var colorsTotalHours = ['#20b6da','#f4a261','#61ba61','#fa5c7c','#775dd0d9'];

var optionsColumnTotalHours = {
          series: [{
            name: "hours",
          data: stuHours,
        }],
          chart: {
          height: 350,
          type: 'bar',
          events: {
            click: function(chart, w, e) {
              // console.log(chart, w, e)
            }
          }
        },
        colors: colorsTotalHours,
        plotOptions: {
          bar: {
            columnWidth: '45%',
            distributed: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        legend: {
          show: false
        },
        xaxis: {
          categories: [
            'Core Hours',
            'Non-Core Hours',
            'Hours Completed',
            'Hours Required',                                               
          ],
          labels: {
            style: {
              colors: colorsTotalHours,
              fontSize: '12px'
            }
          }
        }
        };

        var chart1 = new ApexCharts(document.querySelector("#column-chart-totalHours"), optionsColumnTotalHours);
        chart1.render();

var hourProgressColor = ['#fa5c7c','#61ba61'];

var optionsHourProgress = {
          series: [{
          data: stuBarHours
        }],
          chart: {
          type: 'bar',
          height: 380
        },
        plotOptions: {
          bar: {
            barHeight: '50%',
            distributed: true,
            horizontal: true,
            dataLabels: {
              position: 'bottom'
            },
          }
        },
        colors: hourProgressColor,
        dataLabels: {
          enabled: true,
          textAnchor: 'start',
          style: {
            colors: ['#fff']
          },
          formatter: function (val, opt) {
            return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
          },
          offsetX: 0,
          dropShadow: {
            enabled: true
          }
        },
        stroke: {
          width: 1,
          colors: ['#fff']
        },
        xaxis: {
          categories: ['Hours Required', 'Hours Completed'],
          labels: {
            formatter: function (val) {
              return Math.abs(Math.round(val)) + ":00"
            }
          }
        },
        yaxis: {
          labels: {
            show: false
          }
        },
        // title: {
        //     text: 'Custom DataLabels',
        //     align: 'center',
        //     floating: true
        // },
        // subtitle: {
        //     text: 'Category Names as DataLabels inside bars',
        //     align: 'center',
        // },
        tooltip: {
          theme: 'dark',
          x: {
            show: false
          },
          y: {
            title: {
              formatter: function () {
                return ''
              }
            }
          }
        }
        };

        var chart2 = new ApexCharts(document.querySelector("#hour-progress"), optionsHourProgress);
        chart2.render();

var colorsCoreNonCore = ['#20b6da','#e9c46e'];
var optionsColumnCoreNonCore = {
          series: [{
            name: "hours",
          data: stuCoreNonCore,
        }],
          chart: {
          height: 350,
          type: 'bar',
          events: {
            click: function(chart, w, e) {
              // console.log(chart, w, e)
            }
          }
        },
        colors: colorsCoreNonCore,
        plotOptions: {
          bar: {
            columnWidth: '45%',
            distributed: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        legend: {
          show: false
        },
        xaxis: {
          categories: [
            'Core Hours',
            'Non-Core Hours',                                                           
          ],
          labels: {
            style: {
              colors: colorsCoreNonCore,
              fontSize: '12px'
            }
          }
        }
        };

        var chart3 = new ApexCharts(document.querySelector("#core-nonCore"), optionsColumnCoreNonCore);
        chart3.render();

var coreSubjectsColumnColors = [];
var colorArray = ['#e9c46e','#f4a261','#20b6da','#fa5c7c','#61ba61','#b883c2']
for(var i = 0; i < coreSubjectsColumn.length; i++)
{
  coreSubjectsColumnColors.push(colorArray[Math.floor(Math.random() * colorArray.length)]);  
}
var optionscoreSubjectsColumn = {
          series: [{
            name: "hours",
          data: coreSubjectsTimeColumn,
        }],
          chart: {
          height: 350,
          type: 'bar',
          events: {
            click: function(chart, w, e) {
              // console.log(chart, w, e)
            }
          }
        },
        colors: coreSubjectsColumnColors,
        plotOptions: {
          bar: {
            columnWidth: '45%',
            distributed: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        legend: {
          show: false
        },
        xaxis: {
          categories: coreSubjectsColumn,
          labels: {
            style: {
              colors: coreSubjectsColumnColors,
              fontSize: '12px'
            }
          }
        }
        };

        var chart4 = new ApexCharts(document.querySelector("#core-subjects"), optionscoreSubjectsColumn);
        chart4.render();

var nonCoreSubjectsColumnColors = [];
for(var i = 0; i < coreSubjectsColumn.length; i++)
{
  // nonCoreSubjectsColumnColors.push(randomColor());
  nonCoreSubjectsColumnColors.push(colorArray[Math.floor(Math.random() * colorArray.length)]);
}
var optionscoreSubjectsColumn = {
          series: [{
            name: "hours",
            data: nonCoreSubjectsTimeColumn,            
        }],
          chart: {
          height: 350,
          type: 'bar',
          events: {
            click: function(chart, w, e) {
              // console.log(chart, w, e)
            }
          }
        },
        colors: nonCoreSubjectsColumnColors,
        plotOptions: {
          bar: {
            columnWidth: '45%',
            distributed: true,
          }
        },
        dataLabels: {
          enabled: false,          
        },
        legend: {
          show: false
        },
        xaxis: {
          categories: nonCoreSubjectsColumn,
          labels: {
            style: {
              colors: nonCoreSubjectsColumnColors,
              fontSize: '12px'
            }
          }
        }
        };

        var chart5 = new ApexCharts(document.querySelector("#nonCore-subjects"), optionscoreSubjectsColumn);
        chart5.render();

