<?php
namespace app\index\controller;
use think\Config;
use think\Request;
use think\Db;
use think\db\Query;
class Demo extends Base{
	
	//空操作
	public function _empty($name){
		return $this->showEmptyOperate($name);
	}
	
	protected function showEmptyOperate($name){
		return "当前操作为：".$name ."，此操作没有找到！ ";
	}
	
	
	//路由配置通用配置
	public function route(){
		echo \think\Request::instance()->get('type');
		return dump($_GET);
	}
	//组合路由变量
	public function route1($type){
		echo $type;
		return dump($_GET);
	}
	
	//miss路由
	public function miss(){
		return "dsdsds";
	}
	
    //配置demo
    public function index(){
    	echo \think\Request::instance()->get('name');
		//读取配置(由于配置文件路径更换，无法加载config/common.php，所以无法读取其中配置)
		echo config('demo1');//使用助手函数config读取配置
		echo Config::get('demo1');//使用get方法读取配置文件，需要添加Config（use think\Config;）才可以使用
		dump(config('?demo1'));//使用助手函数 判断配置参数是否存在 返回false
		dump(Config::has('demo1'));
		
		//手动将配置文件加载进来，需要使用完整路径（load方法只有一个参数）
//		Config::load(APP_PATH.'../config/demo.php');
//		echo config('demo1');//使用助手函数config读取配置
//		echo Config::get('demo1');//使用get方法读取配置文件，需要添加Config（use think\Config;）才可以使用
//		dump(config('?demo1'));//使用助手函数 判断配置参数是否存在 返回false
//		dump(Config::has('demo1'));
		
		//load 方法第二个参数表示设置二级配置
//		Config::load(APP_PATH.'../config/demo.php','demo');
//		echo config('demo.demo1');//使用助手函数config读取配置
//		echo Config::get('demo.demo1');//使用get方法读取配置文件，需要添加Config（use think\Config;）才可以使用
//		dump(config('?demo.demo1'));//使用助手函数 判断配置参数是否存在 返回false
//		dump(Config::has('demo.demo1'));
		
		//load方法第三个参数表示作用域,设置了作用域后，需要range到作用域下才能使用，否则不能使用
		Config::load(APP_PATH.'../config/demo.php','demo','test');
		echo config('demo.demo1');//使用助手函数config读取配置
		echo Config::get('demo.demo1');//使用get方法读取配置文件，需要添加Config（use think\Config;）才可以使用
		dump(config('?demo.demo1'));//使用助手函数 判断配置参数是否存在 返回false
		dump(Config::has('demo.demo1'));
		
		//切换到test作用域
		Config::range('test');
		echo config('demo.demo1');//使用助手函数config读取配置
		echo Config::get('demo.demo1');//使用get方法读取配置文件，需要添加Config（use think\Config;）才可以使用
		dump(config('?demo.demo1'));//使用助手函数 判断配置参数是否存在 返回false
		dump(Config::has('demo.demo1'));
    }
    
    /*请求信息*/
    public function req(Request $request){
    	//$request = Request::instance();
    	echo "获取URL信息如下：<br/>";
    	echo "域名：".$request->domain().'<br/>';
		echo '获取当前入口文件: ' . $request->baseFile() . '<br/>';
		echo '获取当前URL地址 不含域名: ' . $request->url() . '<br/>';
		echo '获取包含域名的完整URL地址: ' . $request->url(true) . '<br/>';
		echo '获取当前URL地址 不含QUERY_STRING: ' . $request->baseUrl() . '<br/>';
		echo '获取URL访问的ROOT地址:' . $request->root() . '<br/>';
		echo '获取URL访问的ROOT地址 包含域名: ' . $request->root(true) . '<br/>';
		echo '获取URL地址中的PATH_INFO信息: ' . $request->pathinfo() . '<br/>';
		echo '获取URL地址中的PATH_INFO信息 不含后缀: ' . $request->path() . '<br/>';
		echo '获取URL地址中的后缀信息: ' . $request->ext() . '<br/>';
		
		echo "当前模块名称是" . $request->module(). '<br/>';
		echo "当前控制器名称是" . $request->controller(). '<br/>';
		echo "当前操作名称是" . $request->action(). '<br/>';
		echo '请求方法：' . $request->method() . '<br/>';
		
		echo '资源类型：' . $request->type() . '<br/>';
		echo '访问ip地址：' . $request->ip() . '<br/>';
		echo '是否AJax请求：' . var_export($request->isAjax(), true) . '<br/>';
		echo '请求参数：'. '<br/>';
		dump($request->param()). '<br/>';
		echo '请求参数：仅包含name'. '<br/>';
		dump($request->only(['name'])). '<br/>';
		echo '请求参数：排除name';
		dump($request->except(['name'])). '<br/>';
		
		echo '路由信息：'. '<br/>';
		dump($request->route()). '<br/>';
		echo '调度信息：'. '<br/>';
		dump($request->dispatch()). '<br/>';
    }
    
    /*输入变量*/
   	public function inreq(){
   		dump(Request::instance()->has('id','get'));
   		dump(input('?get.id'));//助手函数
   		dump(Request::instance()->param());
   		dump(input('param.'));
   	}
    
    /*数据库测试*/
    public function dbtest(){
/*************************************开始基本使用*********************************/    	
    	//查询
//  	$info = Db::query('select * from blog_test where id=1');//普通查询
//  	$info = Db::query('select * from blog_test where id=?',[1]);//参数绑定
//  	$info = Db::query('select * from blog_test where id=:id',['id'=>1]);//占位符查询
//  	dump($info);
    	
      	//数据操作
//    	for($i=0;$i<5000;$i++){
//	      	$flag = Db::execute('insert into blog_test (name,time,aa,bb,cc) values(?,?,?,?,?)',['name'.mt_rand(1,9999999),time(),'aa'.mt_rand(1000,9999),'bb'.mt_rand(10000,99999),'cc'.mt_rand(100000,999999)]);//参数绑定插入
//	      	$flag = Db::execute('insert into blog_test (name,time,aa,bb,cc) values(:name,:time,:aa,:bb,:cc)',['name'=>'name'.mt_rand(1,9999999),'time'=>time(),'aa'=>'aa'.mt_rand(1000,9999),'bb'=>'bb'.mt_rand(10000,99999),'cc'=>'cc'.mt_rand(100000,999999)]);//占位符插入
//		}
//    	dump($flag);
/*************************************结束基本使用*********************************/  
    	
    	
/*************************************开始查询构造器*********************************/  
    	/*************************************查询数据*********************************/  
    	//查询一个数据使用find
    	//$info = Db::table('blog_test')->where('id',1)->find();	dump($info);
    	//使用了数据库配置前缀使用Db::name
    	//$info = Db::name('test')->where('id',1)->find();	dump($info);
    	
    	//查询多条数据使用select
    	//$info = Db::table('blog_test')->select();	dump($info);
    	//$info = Db::name('test')->select();	dump($info);
    	
    	//使用助手函数db
    	//$info = db('test')->where('id',1)->find();	dump($info);
    	//$info = db('test')->select();	dump($info);
    	
    	//注意：使用db助手函数默认每次都会重新连接数据库，而使用Db::name或者Db::table方法的话都是单例的。db函数如果需要采用相同的链接，可以传入第三个参数
    	//db('test',[],false)->where('id',1)->find();
		//db('test',[],false)->where('status',1)->select();
    	//上面的方式会使用同一个数据库连接，第二个参数为数据库的连接参数，留空表示采用数据库配置文件的配置。
    	
    	//使用Query对象查询
    	//$query = new \think\db\Query();
    	//$query->table('blog_test')->where('id',1);
    	//$query1->name('test')->where('id',1);
    	//注意Query对象只能使用一次,Query对象查询不能使用name
    	//$info = Db::find($query);	dump($info);
    	//$info = Db::select($query1);	dump($info);
    	
    	//闭包查询(注意闭包可以使用name)
    	//$info = Db::select(function($query){
    	//	$query->table('blog_test')->where(['id'=>['in','1,2,3']]);
    	//});	dump($info);
    	//$info = Db::select(function($query){
    	//	$query->name('test')->where(['id'=>['in','1,2,3']]);
    	//});	dump($info);
    	
    	//查询某个字段的值
    	//$v = Db::name('test')->where('id',1)->value('name');	dump($v);//name查询
    	//$v = Db::table('blog_test')->where('id',1)->value('name');	dump($v);//table查询
      	//$v = Db::find(function($query){
      	//	$query->table('blog_test')->where('id',1)->value('name');
      	//});		dump($v);	//闭包查询失败
      	//$v = db('test')->where('id',1)->value('name');	dump($v);//助手函数查询
    	
    	//查询某列值
    	//$cv = Db::table('blog_test')->column('aa');	dump($cv);	//table查询
    	//$cv = Db::name('test')->column('aa');		dump($cv);	//name查询
    	//$cv = db('test')->column('aa');				dump($cv);	//助手函数查询
    	//$cv = Db::name('test')->column('aa','id');	dump($cv);	//指定索引
    	//$cv = Db::name('test')->column('id,aa,bb');	dump($cv);	//指定查询多个字段列(需要指定主键或索引)
    	
    	//数据集分批处理
    	//$info = Db::name('test')->where('id','<',103)->chunk(50,function($data){
    	//	foreach($data as $d){
    	//		echo $d['id']."<br/>";
    	//	}
    	//},'id','desc');
    	
    	/*************************************查询数据*********************************/ 
    	
    	/*************************************添加数据*********************************/
    	//添加一条数据使用insert
    	//Db::name('test')->insert(['name'=>'lijianlin','time'=>time(),'aa'=>'aa1','bb'=>'bb1','cc'=>'cc1']);//使用name添加数据
    	//Db::table('blog_test')->insert(['name'=>'lijianlin2','time'=>time(),'aa'=>'aa2','bb'=>'bb2','cc'=>'cc2']);//使用table添加数据
    	
    	//返回新增ID
    	//Db::name('test')->insert(['name'=>'lijianlin','time'=>time(),'aa'=>'aa1','bb'=>'bb1','cc'=>'cc1']);
    	//$id = Db::name('test')->getLastInsID();	dump($id);//使用getLastInsID获取新增的ID
    	//$id = Db::name('test')->insertGetId(['name'=>'lijianlin','time'=>time(),'aa'=>'aa1','bb'=>'bb1','cc'=>'cc1']);
    	//dump($id);	//使用insertGetId($data)返回新增ID
    	
    	//添加多条数据使用insertAll($data)
    	$data = [
    		['name'=>'lijianlin','time'=>time(),'aa'=>'aa1','bb'=>'bb1','cc'=>'cc1'],
    		['name'=>'lijianlin','time'=>time(),'aa'=>'aa2','bb'=>'bb2','cc'=>'cc2'],
    		['name'=>'lijianlin','time'=>time(),'aa'=>'aa3','bb'=>'bb3','cc'=>'cc3']
    	];
    	//Db::name('test')->insertAll($data);
    	
    	//助手函数插入数据
    	//db('test')->insert(['name'=>'lijianlin','time'=>time(),'aa'=>'aa1','bb'=>'bb1','cc'=>'cc1']);
    	//db('test')->insertAll($data);
    	
    	//快捷操作
    	//Db::name('test')->data(['name'=>'lijianlin','time'=>time(),'aa'=>'aa1','bb'=>'bb1','cc'=>'cc1'])->insert();
    	//$id = Db::name('test')->getLastInsID();	dump($id);
    	
    	/*************************************添加数据*********************************/
    	
    	/*************************************更新数据*********************************/
    	//更新数据使用update
    	//Db::table('blog_test')->where('id',1)->update(['name'=>'lijianlin0204']);	//table更新数据
    	//Db::name('test')->where('id',1)->update(['name'=>'123468888']);	//name更新数据
    	//db('test')->where('id',1)->update(['name'=>'hskadhjahfad']);	//助手函数更新数据
    	//包含主键可以放在data里面,在自动识别
    	//Db::name('test')->update(['name'=>'kkkkkk','id'=>1]);
    	
    	//update 方法返回影响数据的条数，没修改任何数据返回 0
    	//$flag = Db::name('test')->where('id',1)->update(['name'=>'kkkkkk']);	//dump($flag);
    	//强制更新判断全等于0即可（tp3使用 false）
    	//if($flag !== 0){
    	//	return true;
    	//}
    	
    	//更新使用SQL函数
    	//Db::name('test')->where('id',4)->update(['time'=>['exp','now()']]);
    	//Db::name('test')->where('id',4)->update(['aa'=>['exp','aa+1']]);
    	
    	//更新某个字段
    	//Db::name('test')->where('id',4)->setField('name','blog');
    	
    	//自增自减
    	//Db::name('test')->where('id',4)->setInc('aa');//自增默认为1
    	//Db::name('test')->where('id',4)->setInc('aa',5);//设置自增步长
    	//Db::name('test')->where('id',4)->setDec('aa');//自减
    	//Db::name('test')->where('id',4)->setDec('aa',4);//设置自减步长
    	//setInc和setDec支持延迟更新
    	//Db::name('test')->where('id',4)->setInc('aa',1,10);//延迟10秒自增
    	
    	//快捷更新
    	//Db::name('test')->where('id',4)->inc('aa')->dec('bb',3)->exp('name','UPPER(name)')->update();
    	
    	/*************************************更新数据*********************************/
    	
    	/*************************************删除数据*********************************/
    	//删除数据使用delete
    	//Db::table('blog_test')->where('id',20014)->delete();//条件删除
    	//Db::name('test')->delete(20013);//主键删除
    	//db('test')->delete(20012);//助手函数删除
    	//db('test')->delete([20011,10010]);
    	
    	/*************************************删除数据*********************************/
    	
    	/*************************************查询事件*********************************/
    	//查询事件仅支持find、select、insert、update和delete方法。
    	//Query::event('after_insert','callback');
		//Query::event('before_select',function($options,$query){
			// 事件处理
		//   return $result;
		//});
    	
    	/*************************************查询事件*********************************/
    	
    	/*************************************事物处理*********************************/
    	//自动事物处理
    	//Db::transaction(function(){
    	//	Db::name('test')->find(1);
    	//	Db::name('test')->delete(1);
    	//});
    	
    	//手动事物处理
    	//Db::startTrans();
    	//try{
    		//Db::name('test')->insert(['id'=>1,'name'=>'1111']);
    		//Db::name('test')->insert(['id'=>2,'name'=>'1111']);
    		//Db::commit();
    	//}catch(\Exception $e) {
    		//Db::rollback();
    	//}
    	
    	/*************************************事物处理*********************************/
    	
    	
/*************************************结束查询构造器*********************************/  
    }
    
    
    
}
