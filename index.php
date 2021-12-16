<?php
$message_file = file_get_contents('messages.txt');
$message_text = explode(PHP_EOL,$message_file);
$name_file=file_get_contents('people.json');
$name_array= json_decode($name_file,true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $en_name = $_POST['person'];
    $fa_name=$name_array[$en_name];
    $question=$_POST['question'];
    $msg=$message_text[(intval(hash('md5', $en_name.$question),10) % 16)];
    $first = "/^آیا/iu";
    $last1 = "/\?$/i";
    $last2 = "/؟$/u";
    if (!(preg_match($last1, $question)||preg_match($last2, $question))){
            $msg="سوال درستی پرسیده نشده";}
         
    if (!preg_match($first, $question)){
            $msg="سوال درستی پرسیده نشده";}}      
else {
    $msg = "سوال خود را بپرس!";
    $question = '';
    $en_name = array_rand($name_array);
    $fa_name = $name_array[$en_name];
}
if (empty($question)){
    $msg="سوال خود را بپرس!";
    $label_val='';}

else {
       $label_val='پرسش:';}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <span id="label"><?php echo $label_val ?></span>
        <span id="question"><?php echo $question ?></span>
    </div>
    <div id="container">
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
               $input=file_get_contents('people.json');
                        $names=json_decode($input);
                            foreach($names as $key => $value){
                                if ($key!=$en_name){
                               echo "<option value=$key> $value </option>";}
                                    
                                else{
                               echo "<option value=$key selected> $value </option>";}
                            }
                 ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>