<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Boone graph demo</title>
        <link href="./booneGraph/css/jquery-ui-1.10.2.custom.min.css" rel="stylesheet" type="text/css" />
        <link href="./booneGraph/css/viznetworks.css" rel="stylesheet" type="text/css" />
        <link href="./booneGraph/css/demo.css" rel="stylesheet" type="text/css" />
        <link href="./css/booneGraph.css" rel="stylesheet"  type="text/css">

        <script src="./booneGraph/js/jquery-1.8.2.min.js" type="text/javascript"></script>
        <script src="./booneGraph/js/jquery-ui-1.10.2.custom.min.js" type="text/javascript"></script>
        <script src="./booneGraph/js/isigma.js" type="text/javascript"></script>
        <script src="./booneGraph/js/sigma_plugins/sigma.parseBooneGexf.js" type="text/javascript"></script>
        <script src="./booneGraph/js/sigma_plugins/sigma.parseJson.js" type="text/javascript"></script>
        <script src="./booneGraph/js/sigma_plugins/sigma.parseGml.js" type="text/javascript"></script>
        <script src="./booneGraph/js/sigma_plugins/sigma.forceatlas2.js" type="text/javascript"></script>
        <script src="./booneGraph/js/sigma_plugins/sigma.fruchterman.js" type="text/javascript"></script>
        <script src="./booneGraph/js/sigma_plugins/sigma.forcelayout.js" type="text/javascript"></script>
        <script src="./booneGraph/js/sigma_plugins/sigma.boonetools.js" type="text/javascript"></script>
        <script src="./booneGraph/js/jquery.contextMenu.js" type="text/javascript"></script>
        <script src="./booneGraph/js/fullscreen.js" type="text/javascript"></script>
        <script src="./booneGraph/js/colors.js" type="text/javascript"></script>
        <script src="./booneGraph/js/jquery.booneGraph.js" type="text/javascript"></script>
        <script src="./booneGraph/js/spectrum.min.js" type="text/javascript"></script>
        <script src="./booneGraph/js/utils.js" type="text/javascript"></script>
        <script type="text/javascript">
            (function($){
                $(document).ready(function(){
                    var sBox='<div id="sBox">'+
                        '<input id="s" type="text" value=" 台湾,套图"/>'+
                        '<button id="sBtn">choose</button>'+
                        '<button id="rsBtn">reset</button>'+
                        '</div>';
                    $("#network-container").append(sBox);
                    $("#network-container").booneGraph({
                        layouts: [{
                                id: "s2010",
                                url:  "./booneGraph/data/network_1.gml",
                                //url:  "./booneGraph/data/data/network.gml",
                                name: "Science 2010",
                                parser: "gml"
                            }],
                        annotations: [{
                                //id: "costanzo10",
                                //url: "http://spidey.ccbr.utoronto.ca/~matej/booneGraph/data/costanzo10.json",
                                //name: "Group 10"
                            }],
                        nodesUrl:'./booneGraph/data/network_1.json'
                    });
                    $('#load-layout-s2010').trigger('click');
                    $('#s').focus(function(){$(this).val('');});
                    
                    $('#rsBtn').click(function(){
                        $('#load-layout-s2010').trigger('click');
                        $('#word_links').empty();
                        $('#filelist').empty();
                    });
                    
                    $('#menu-getfile-nodes').live('click',function(){   
                        var proverb = '';
                        var html = '';
                        $('.selected-node-item').each(function(i,e){
                            proverb += $(e).text() + " ";
                            html += ' <a  class="keyword" href="javascript:void(0)">' + $(e).text() + '</a> |';
                        });
                        html = html.substr( 0 , html.length-1 );
                        $('#word_links').html(html);
                        /*
                        $.ajax({
                             type : 'post'
                            ,url:'getFileListByWord.php'
                            ,dataType:'json'
                            ,data:{
                                words:proverb 
                            }
                            ,async: false
                            ,success:function(data){   
                                $('#filelist-container').empty();
                                
                                var html = '<table id="list_tab">';
                                html += '<tr><th width="21%">keyword</th><th width="58%">filename</th><th width="21%">ip_count</th></tr>';
                                $.each(data, function(i,e){
                                    html += makeItems(i,e);
                                });
                                html += '</table>';
                                
                                $('#filelist-container').append(html); 
                            }
                        });
                        */
                    });
                    
                    $('#getAll').live('click',function(){
                        var proverbs = '';
                        $('.selected-node-item').each(function(i,e){
                            proverbs += $(e).text() + " ";
                        });
                        $.ajax({
                             type : 'post'
                            ,url:'getFileListByWord.php'
                            ,dataType:'json'
                            ,data:{
                                type : "all",
                                words : proverbs 
                            }
                            ,async: false
                            ,success:function(data){ 
                                $('#filelist').empty();
                                var html = '<table id="list_tab">';
                                html += '<tr><th width="20%">keyword</th><th width="60%">filename</th><th width="20%">ip_count</th></tr>';
                              
                                html += makeItems(proverbs,data);
                               
                                html += '</table>';
                                
                                $('#filelist').append(html); 
                            }
                        });
                        
                        
                    });
                    
                    
           
                    
                    
                    $('.keyword').live('click',function(){
                        var keyword = $(this).text();   
                        $.ajax({
                             type : 'post'
                            ,url:'getFileListByWord.php'
                            ,dataType:'json'
                            ,data:{
                                type:"single",
                                words:keyword 
                            }
                            ,async: false
                            ,success:function(data){   
                                $('#filelist').empty();
                                
                                var html = '<table id="list_tab">';
                                html += '<tr><th width="20%">keyword</th><th width="60%">filename</th><th width="20%">ip_count</th></tr>';
                                $.each(data, function(i,e){
                                    html += makeItems(i,e);
                                });
                                html += '</table>';
                                
                                $('#filelist').append(html); 
                            }
                        });      
                    });
                    
                    
     
                });
                
                function makeItems(word,data){
                    var html = '<tr><td class="w_td" width="20%">' + word + '</td><td width="80%" colspan=2><table class="inner_tab">';
                    if(data == null){
                        html += '<tr><td class="i_td_file" width="75%">No file</td><td class="i_td_ip" width="25%"> 0 </td></tr>';
                    }else{
                        $.each(data, function(i,e){
                            var ip_count;
                            if(e.ip_count == null){
                                ip_count = 0;
                            }else{
                                ip_count = e.ip_count;
                            }
                            html += '<tr><td class="i_td_file" width="75%">'  + e.file + '</td><td class="i_td_ip" width="25%">' + ip_count + '</td></tr>';                          
                        });
                    }
                    html+='</table></td></tr>';
                    return html;
                }

            })(jQuery);
        </script>
    </head>
    <body>
        <div id="network-container" class="sigma-expand"></div>
        <div id="filelist-container">
           <div id="filelist_header">
                <p id="getTitle">获取关键词对应的文件及IP数量： </p> <p id = "getAll"><a href="javascript:void(0)"> 获取关键词同时出现的文件</a></p>
           </div>  
           <p id="word_links"></p>
           <div id="filelist"></div>
        </div>
    </body>
</html>
