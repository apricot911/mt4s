<style type="text/css">
    body{
        padding-top:50px;
    }
    .instance_box{
        height:150px;
        background:#faebcc;
    }
    #information{
        height:200px;
        /*margin-top:10px;*/
        /*margin-bottom:10px;*/
        background:#bce8f1;
    }
    #navigation{
        padding-top:10px;
        padding-bottom:10px;
        background:#d58512;
    }
    #instancelist{
        /*margin-top:10px;*/
    }
    .chart {
        /*position: relative;*/
        display: inline-block;
        /*width: 11;*/
        /*height: 110px;*/
        margin-top: 50px;
        margin-bottom: 50px;
        text-align: center;
    }
    .chart canvas {
        position: absolute;
        top: 0;
        left: 0;
    }
</style>
<div class="container">
   <div class="row">
       <div class="col-xs-10 col-xs-offset-1">
            <!-- Main -->
           <div class="row">
               <div class="col-xs-12" id="information">

                   info
               </div>
           </div>
           <div class="row">
               <div class="col-xs-12" id="navigation">
                   <div class="row text-center">
                       <div class="col-xs-1">
                           <button class="btn btn-primary">起動</button>
                       </div>
                       <div class="col-xs-1">
                           <button class="btn btn-danger">停止</button>
                       </div>
                       <div class="col-xs-1 col-xs-offset-6">
                           <button class="btn btn-primary">新規</button>
                       </div>
                       <div class="col-xs-1">
                           <button class="btn btn-info">詳細</button>
                       </div>
                       <div class="col-xs-2">
                           <button class="btn btn-danger">削除</button>
                       </div>
                   </div>
               </div>
           </div>
           <div class="row">
               <div class="col-xs-12 text-center" id="instancelist">
                   <div class="row">
                       <div class="col-xs-3 instance_box">
                           <a href="instance.php?id=1" style="display: block;">instance</a>
                       </div>
                       <div class="col-xs-3 instance_box">
                           instance
                       </div>
                       <div class="col-xs-3 instance_box">
                           instance
                       </div>
                       <div class="col-xs-3 instance_box">
                           instance
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-xs-3 instance_box">
                           instance
                       </div>
                       <div class="col-xs-3 instance_box">
                           instance
                       </div>
                       <div class="col-xs-3 instance_box">
                           instance
                       </div>
                       <div class="col-xs-3 instance_box">
                           instance
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-xs-3 instance_box">
                           instance
                       </div>
                       <div class="col-xs-3 instance_box">
                           instance
                       </div>
                       <div class="col-xs-3 instance_box">
                           instance
                       </div>
                       <div class="col-xs-3 instance_box">
                           instance
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-xs-3 instance_box">
                           instance
                       </div>
                       <div class="col-xs-3 instance_box">
                           instance
                       </div>
                       <div class="col-xs-3 instance_box">
                           instance
                       </div>
                       <div class="col-xs-3 instance_box">
                           instance
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
</div>
<div data-spy="affix" data-offset-top="60" data-offset-bottom="200">
    ...
</div>
<script type="text/javascript">
    $('.chart').easyPieChart({
        easing: 'easeOutBounce',
        onStep: function(from, to, percent) {
            $(this.el).find('.percent').text(Math.round(percent));
        }
    });
</script>
</body>
</html>