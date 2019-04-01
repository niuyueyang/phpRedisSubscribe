<?php
$con = mysqli_connect("localhost","root","root",'test');
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "test";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$redis = new Redis();
$redis->connect('127.0.0.1',6379);

echo 'reading c1 ...\n';

//设置超时控制
$redis->setOption(Redis::OPT_READ_TIMEOUT,-1);

$redis->subscribe(['c1','c2'],function(Redis $instance, $channel, $message)use($conn){
    if($message) {
        $sql = "insert into user(channel,msg) values('" . $channel . "','" . $message . "')";
        if ($conn->query($sql) === TRUE) {
            echo "新记录插入成功";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
});
