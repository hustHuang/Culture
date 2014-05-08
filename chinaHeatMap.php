<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>amMap example</title>

        <link rel="stylesheet" href="./ammap/ammap.css" type="text/css">  
        <link rel="stylesheet" href="./css/chinaHeatMap.css" type="text/css">
        <script src="./ammap/ammap.js" type="text/javascript"></script>
        <!-- map file should be included after ammap.js -->
        <script src="./ammap/maps/js/chinaLow.js" type="text/javascript"></script>
        <script src="./booneGraph/js/jquery-1.8.2.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            var map;		
            AmCharts.ready(function() {
                map = new AmCharts.AmMap();
                map.pathToImages = "./ammap/images/";
                //map.panEventsEnabled = true; // this line enables pinch-zooming and dragging on touch devices	    
                map.colorSteps = 50;
			    
                var dataProvider = {
                    mapVar: AmCharts.maps.chinaLow,	
                    areas: [
                        {id:"CN-34",value:12521},
                        {id:"CN-11",value:13389},
                        {id:"CN-50",value:9475},
                        {id:"CN-35",value:8360},
                        {id:"CN-44",value:26721},
                        {id:"CN-62",value:2441},
                        {id:"CN-45",value:9230},
                        {id:"CN-52",value:2870},
                        {id:"CN-46",value:1824},
                        {id:"CN-13",value:14775},
                        {id:"CN-41",value:16094},
                        {id:"CN-91",value:1952},//Hong Kong
                        {id:"CN-23",value:8441},
                        {id:"CN-43",value:8745},
                        {id:"CN-42",value:13195},
                        {id:"CN-22",value:5777},
                        {id:"CN-32",value:41730},
                        {id:"CN-36",value:12955},
                        {id:"CN-21",value:12681},
                        {id:"CN-92",value:92},//Macau
                        {id:"CN-15",value:3636},
                        {id:"CN-64",value:995},
                        {id:"CN-63",value:547},
                        {id:"CN-61",value:7304},
                        {id:"CN-51",value:15679},
                        {id:"CN-37",value:34756},
                        {id:"CN-31",value:7520},
                        {id:"CN-14",value:7040},
                        {id:"CN-12",value:5497},
                        {id:"CN-71",value:30883},
                        {id:"CN-65",value:2447},
                        {id:"CN-54",value:93},
                        {id:"CN-53",value:4838},
                        {id:"CN-33",value:29065}
                    ]
                };
			
                map.areasSettings = {
                    autoZoom: false
                };
				
                map.dataProvider = dataProvider;
                
                //CUSTOM OPTION
                map.allowClickOnSelectedObject = true;
                map.dragMap = false;
                map.zoomOnDoubleClick = false;
                map.zoomControl = {
                    zoomControlEnabled : false,
                    panControlEnabled : false
                };
                var valueLegend = new AmCharts.ValueLegend();
                valueLegend.right = 10;
                valueLegend.minValue = "Min";//93
                valueLegend.maxValue = "Max";//34756
                map.valueLegend = valueLegend;	
                map.write("mapdiv");
                
                
                map.addListener("click", function(e){       
                    var data = e.chart ;
                    var  title = data.balloon.text;
                    var  provience  = $.trim(title.split(":")[0]); 
                    $.ajax({
                            type :'post'
                            ,url:'getIPByProvince.php'
                            ,dataType:'json'
                            ,data:{
                                provience:provience 
                            }
                            ,async: false
                            ,success:function(data){ 
                                 var html = '<p>' + data[0].province + '省 数量前20的ip分布情况</p>';
                                 html += '<table><tr><th>index</th><th>ip</th><th>total</th><th>area</th></tr>';
                                 $.each(data,function(i,e){
                                     html += '<tr><td>'+(i+1)+'</td><td>'+e.ip+'</td><td>'+e.total+'</td><td>'+e.area+'</td></tr>';  
                                 });
                                 html += '</table>';
                                 $('#tabdiv').html(html);
                            }
                     });  
                });
                
            });
        </script>
    </head>

    <body>
        <div id="mapdiv"></div>
        <div id="tabdiv">
            <div id="p" style="width: 200px;margin:100px auto;height: 100px;line-height: 30px;">
                点击对应的省份获取IP分布情况
            </div>
        </div>
    </body>

</html>