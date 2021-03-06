<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>System Set</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <!-- Bootstrap styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
  

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">

    <!-- Google Webfonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600|PT+Serif:400,400italic' rel='stylesheet' type='text/css'>

    <!-- Styles -->
  <link rel="stylesheet" href="css/style.css" id="theme-styles">

    <!--[if lt IE 9]>      
        <script src="js/vendor/google/html5-3.6-respond-1.1.0.min.js"></script>
    <![endif]-->
    
</head>

<body>

    <header>
        <div class="widewrapper masthead">
            <div class="container">
                <a href="index.html" id="logo">
                    <h1>Lucky</h1>
                </a>

                <div id="mobile-nav-toggle" class="pull-right">
                    <a href="#" data-toggle="collapse" data-target=".clean-nav .navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>

                <nav class="pull-right clean-nav">
                    <div class="collapse navbar-collapse">
                        <ul class="nav nav-pills navbar-nav">

                            <li>
                                <a href="index.php">Home</a>
                            </li>
                            <li>
                                <a href="info.php">INFO</a>
                            </li>
                            <li>
                                <a href="set.php">SET</a>
                            </li>
                        </ul>
                    </div>
                </nav>        

            </div>
        </div>

        <div class="widewrapper subheader">
            <div class="container">

            </div>
        </div>
    </header>

    <div class="widewrapper main">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 clean-superblock" id="contact">
                    <h2>SYSTEM SET</h2>
                    <form action="settojson.php" method="post" accept-charset="utf-8" class="contact-form" enctype="multipart/form-data">
                        <div class="form-group">
                            <fieldset>
                                <legend><h2>背景设置</h2></legend>
                                <label for="bgImage">背景图片</label>
                                <input type="file" id="bgImage" name="bgImage">
                                <label for="bgWidth">背景图片宽度(%)</label>
                                <input type="text" id="bgWidth" class="form-control" name="bgWidth">
                                <label for="bgHeight">背景图片高度(%)</label>
                                <input type="text" id="bgHeight" class="form-control" name="bgHeight">
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend><h2>奖项设置</h2></legend>
                                <div >
                                    <table class="table table-hover" id="tabSet">
                                        <tr>
                                            <th class="text-center">奖项名称</th>
                                            <th class="text-center">可得奖品</th>
                                            <th class="text-center">奖品数量</th>
                                            <th class="text-center"><button type="button" id="btnAdd" class="btn btn-success">新增</button></th>
                                        </tr>

                                    </table>
                                    <input type="hidden" id="hidden" name="tabSet" style="" value="123123123">
                                </div>
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend><h2>待抽奖人员</h2></legend>
                                <label for="idLength">抽奖位数</label>
                                <input type="text" id="idLength" name="idLength" class="form-control" value="">
                                <i>输入数字，一行代表一个人</i>
                                <div >
                                    <textarea name="userIdArray" class="form-control" style="height:  200px"></textarea>
                                </div>
                            </fieldset>
                        </div>
                        <div class="buttons clearfix">
                            <button type="submit" class="btn btn-xlarge btn-clean-one" >Submit</button>
                        </div>                    
                    </form>
                </div>
            </div>        
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/modernizr.js"></script>

    <script>
        $(document).ready(function() {

            $.getJSON("json/conf.json", function (data) {
                //此处返回的data已经是json对象
                $.each(data, function (idx, item) {
                    if (idx == "background") {
                        $("[name='bgWidth']").val(item.width);
                        $("[name='bgHeight']").val(item.height);
                    }
                    else {
                        for (var i = 0; i < item.length; i++) {
                            var luckyName = item[i].luckyName;
                            var prizeName = item[i].prizeName;
                            var luckyNumber = item[i].luckyNumber;
                            //表格新增
                            $("#tabSet").append('<tr>\n' +
                                '                                            <td><input type="text" class="text-center" value="' + luckyName + '"></td>\n' +
                                '                                            <td><input type="text" class="text-center" value="' + prizeName + '"></td>\n' +
                                '                                            <td><input type="text" class="text-center" value="' + luckyNumber + '"></td>\n' +
                                '                                            <td><button type="button" class="btn btn-danger">删除</button></td>\n' +
                                '                                        </tr>');
                            $(".btn-danger").click(function () {
                                $(this).parent().parent().remove();
                            });
                        }
                    }
                });
            });


            $.getJSON("json/user.json", function (data) {
                //此处返回的data已经是json对象
                $.each(data, function (idx, item) {
                    if(idx == "userIdLength"){
                        $("[name='idLength']").val(item);
                    }
                    else
                    {
                        var idString = "";
                        for(var i = 0;i < item.length;i++){
                            idString += item[i] + "\r\n";
                        }
                        $("[name='userIdArray']").val(idString);
                    }
                });
            });



            // 表格新增
            $("#btnAdd").click(function () {
                $("#tabSet").append('<tr>\n' +
                    '                                            <td><input type="text" class="text-center" value=""></td>\n' +
                    '                                            <td><input type="text" class="text-center" value=""></td>\n' +
                    '                                            <td><input type="text" class="text-center" value=""></td>\n' +
                    '                                            <td><button type="button" class="btn btn-danger">删除</button></td>\n' +
                    '                                        </tr>');
                $(".btn-danger").click(function () {
                    $(this).parent().parent().remove();
                });
            });
            
            $(".btn-danger").click(function () {
                $(this).parent().parent().remove();
            });



            //提取表格数据
            $("button[type='submit']").click(function () {
                //获取表格里面的input
                var inputs = $("#tabSet input");
                //luckyObj
                var tabSet = "{\"luckySet\":[";
                var j = 0;
                for(var i = 0;i < inputs.length;i+=3){
                    tabSet += "{\"luckyName\":" ;
                    tabSet += "\"" + inputs[i].value.toString() + "\",";
                    tabSet += "\"prizeName\":" ;
                    tabSet += "\"" + inputs[i+1].value.toString() + "\",";
                    tabSet += "\"luckyNumber\":" ;
                    tabSet += "\"" + inputs[i+2].value.toString() + "\"}";
                    if(i != inputs.length - 3)
                        tabSet += ",";
                    j++;
                }
                tabSet += "]}";
                inputs.attr("disabled","true");
                $("#hidden").val(tabSet);
            });

        });
    </script>

</body>
</html>