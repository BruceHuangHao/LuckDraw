<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/26
 * Time: 17:01
 */


    $bgImageUrl = $bgWidth = $bgHeight = $idLength = $userIdString = "";
    $userIdArray = array();
/*bgImage
tabSet*/

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //上传图片
        if ($_FILES["bgImage"]["name"] && $_FILES["bgImage"]["error"] > 0)
        {
            echo "错误：" . $_FILES["bgImage"]["error"] . "<br>";
        }
        else{
            if(test_image($_FILES["bgImage"]["name"],$_FILES["bgImage"]["type"])) {
                // 保存图片
                move_uploaded_file($_FILES["bgImage"]["tmp_name"], "img/" . $_FILES["bgImage"]["name"]);
                $bgImageUrl = "img/" . $_FILES["bgImage"]["name"];
            }
        }

        $bgWidth = test_input($_POST["bgWidth"]);
        $bgHeight = test_input($_POST["bgHeight"]);
        $tabSet = test_input($_POST["tabSet"]);
        $idLength = test_input($_POST["idLength"]);
        $userIdString = test_input($_POST["userIdArray"]);

        $userIdArray = explode("\r\n",$userIdString);


        //写入conf.json
        $confString = file_get_contents("json/conf.json");
        $confArray = json_decode($confString,true);
        //var_dump($confArray["background"]["url"]);

        if($bgImageUrl != "")
            $confArray["background"]["url"] = $bgImageUrl;
        //var_dump($confArray["background"]["url"]);
        $confArray["background"]["width"] = $bgWidth;
        $confArray["background"]["height"] = $bgHeight;
        //$tabSet to array
        $tabSet = json_decode($tabSet,true);

        $confArray["luckySet"] = array();
        for($i = 0;$i < count($tabSet["luckySet"]); $i++){
            $confArray["luckySet"][$i]["luckyName"] = $tabSet["luckySet"][$i]["luckyName"];
            $confArray["luckySet"][$i]["prizeName"] = $tabSet["luckySet"][$i]["prizeName"];
            $confArray["luckySet"][$i]["luckyNumber"] = $tabSet["luckySet"][$i]["luckyNumber"];
        }
        $confString = json_encode($confArray);
        file_put_contents("json/conf.json",$confString);




        //写入user.json
        $userString = file_get_contents("json/user.json");
        $userArray = json_decode($userString,true);
        $userArray["userIdLength"] = $idLength;
        $userArray["id"] = array();
        for($i = 0;$i < count($userIdArray); $i++){
            $userArray["id"][$i] = $userIdArray[$i];
        }
        $userString = json_encode($userArray);
        file_put_contents("json/user.json",$userString);

        //写入lucky.json
        //$luckyString = file_get_contents("json/lucky.json");
        $luckyArray = array();
        $luckyArray["result"] = array();
        //var_dump($luckyArray["result"]);
        $len = count($confArray["luckySet"]);
        for($i  = 0 ;$i < $len;$i++){
            $luckyArray["result"][$i]  = array();
            $luckyArray["result"][$i]["luckyName"] = $confArray["luckySet"][$i]["luckyName"];
            $luckyArray["result"][$i]["id"] = array();
        }
        $luckyString = json_encode($luckyArray);
        file_put_contents("json/lucky.json",$luckyString);


        $url="index.php";
        echo "<script LANGUAGE='Javascript'>";
        echo "location.href='$url'";
        echo "</script>";
    }
    else{
        echo "<h1>提交出错</h1>";
    }




//---------------function define---------------------//

    //去掉空格制表符，斜杠，把data转化成html实体。防止XSS攻击
    function test_input($data){
        $data = trim($data);
        $data = stripcslashes($data);
        //$data = htmlspecialchars($data);
        return $data;
    }

    //检测是否合法的图片
    function test_image($imageName, $imageType){
        //允许的文件后缀
        $allowFile = array("gif", "jpeg", "jpg", "png", "x-png", "pjpeg");
        //数组，以"."分割的，里面有两个元素
        $temp = explode(".", $imageName);
        //获取后缀名
        $extension = end($temp);
        if(($imageType == "image/jpg"
            || $imageType == "image/gif"
            || $imageType == "image/png"
            || $imageType == "image/jpeg"
            || $imageType == "image/x-png"
            || $imageType == "image/pjpeg")
            // 判断后缀和格式是否一致
            && in_array($extension,$allowFile)){
            return true;
        }
        return false;
    }


?>