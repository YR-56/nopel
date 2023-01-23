

<!DOCTYPE html>


<html lang="ja" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>新規掲示板投稿</title>





</head>
<body>

    <h1>新規投稿フォーム</h1>
    <form action="post.php" method="post" name="novelform" onsubmit="return inputcheck()">

        <p>名前: <input type="text" name="name" id="name"/></p>
        <p id="alarm_name" style="display: none; color:red;">*作者名を入力してください</p>

      
        <p>
            タイトル:
            <input type="text" name="title" id="title" />

        </p>


        <p id="alarm_title" style="display: none; color:red;">*タイトルを入力してください </p>

        

        
        <p>
            内容:
            <textarea name="honbun" cols="40" rows="8" id="honbun"></textarea>

        </p>

        <p id="alarm_honbun" style="display: none; color:red;">内容を入力してください</p>

        <input type="submit" value="送信" />
        
        <input type="hidden" name="token" value="<?php echo hash("sha256", session_id()) ?>">
        
        


    </form>

<script type="text/javascript">
function inputcheck(){
    var flag = 0;
    if(document.novelform.name.value == ""){
        //名前が未入力
        flag = 1;
        document.getElementById('alarm_name').style.display = "block";
    }else{
        document.getElementById('alarm_name').style.display = "none";
    }

    if(document.novelform.summary.value == ""){
        flag = 1;
        document.getElementById('alarm_summary').style.display = "block";
    }else {
        document.getElementById('alarm_summary').style.display = "none";
    }


    if(document.novelform.title.value == ""){
        flag = 1;
        document.getElementById('alarm_title').style.display = "block";
        
    } else {
        document.getElementById('alarm_title').style.display = "none";

    }

    if(document.novelform.honbun.value == ""){
        flag = 1;
        document.getElementById('alarm_honbun').style.display = "block";

    }else {
        document.getElementById('alarm_honbun').style.display = "none";
    }

    if(flag){
        window.alert('必須項目はすべて入力してください。');
        return false;
    }else {
        return true;
    }
    
}

</script>


</body>
</html>