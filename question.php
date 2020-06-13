<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/6/13
 * Time: 22:22
 */

//1.S-3341、UX331、KL^72T如何求其中数字之和(例如：3341+331+72)

$strArr = ['S-3341','UX331','KL^72T'];

$intArr = [];

$result = 0;

foreach ($strArr as $str)
{
    if(preg_match('/\d+/',$str,$arr)){
        $intArr[] = $arr[0];
    }
}

foreach ($intArr as $key => $int)
{
    $result += $int;
}

echo $result ."\r\n";
/*****************************************************/

//2.php实现一个双向数组(可从头尾添加删除元素)

class DoubleList
{
    private $list = [];

    public function push($data)
    {
        return array_push($this->list,$data);
    }

    public function pop()
    {
        return array_pop($this->list);
    }

    public function unShift($data)
    {
        return array_unshift($this->list,$data);
    }

    public function shift()
    {
        return array_shift($this->list);
    }

    public function getList()
    {
        return $this->list;
    }


}

/****************************************************/
//3.数组排序
//合并三个数组
//对合并之后的数组先 height 正序,再 weight 倒序排序

$classOne   = ['one' => ['height' => 170, 'weight' => 50]];
$classThree = ['three' => ['height' => 172, 'weight' => 70]];
$classTwo   = ['two' => ['height' => 172, 'weight' => 60]];

$mergeArr = array_merge($classOne,$classThree,$classTwo);

//height正序
$height = [];
$weight = [];
$arr1 = [];
$arr2 = [];
foreach ($mergeArr as $k => $v)
{
    $height[$k] = $v['height'];
    $weight[$k] = $v['weight'];
}
asort($height);
arsort($weight);
foreach ($height as $key => $value)
{
    $arr1[] = $mergeArr[$key];
}
foreach ($weight as $key => $value)
{
    $arr2[] = $mergeArr[$key];
}

//print_r($arr1);  height
//print_r($arr2);  weight

/***************************************************************/
//4.有一个复合索引：INDEX(`x`, `y`, `z`) 选出以下用不上索引的sql
//A select * from users where x = 1 and y = 2
//B select * from users where y = 2 and x = 1      选B
//C select * from users where x = 2 and z = 1
//D select * from users where y = 2 and z = 1

/***************************************************************/

/*
5.查出下属薪资大于主管的数据(pid代表自己主管id,用SQL解决)
id pid name salary
1  0   小明 4000
2  0   小红 5000
3  1   小王 9000
4  2   小刚 3000
5  4   小鱼 5000
 select b.* from xx as b inner join xx as a where b.pid = a.id and b.salary > a.salary;
*/

/*****************************************************************/

//6.已知某校数据库有两个表, student(学生), class(班级)
//用SQL解决以下问题(此题需细心谨慎)
//把已退学的同学(leave=1)从班级列表删除
//update class set deleted_at = now() where student_id in(select id from student where level = 1)
//找出还未选出班长的班级
//select a.class_id from class as a inner join student as b where a.student_id = b.id group by a.class_id having sum(b.duty) = 0

/********************************************************************/

/*
7.关于 Redis 你对以下4点的理解(口述)
Redis不支持事务
查看生产环境所有key的命令是 keys *
pipeline可以大幅提高效率且可以打包成原子操作
建议的命名规范是room:{roomId}:user:{userId}
*/

//redis 可以支持 利用 MULTI --- EXEC
//是的
//这个没接触过
//是的一直都是这样

/********************************************************************/

/*
8.设计微信发红包的功能,并解决并发问题(口述)
红包如何拆分
    按照拆分数量进入循环，每次拆分金额大小以当前红包剩余金额总量的三分之2(可改)为上限，1分为下限进行随机
    拆到最后一份直接发出去
抢红包的并发问题
    入队列 例如 最简单的redis 链表 或 rabbitmq都可以
 */

/*************************************************************************/

//9.以下中有1亿数据, 写出 更新全表 type 字段等于100的sql

/*
 * 按照数据的id 分批处理 有1亿条数据就按照5000条一批次 分成若干份
 * 或按照 表单进行水平分区，逐个分区更新
 * */

