<?php
namespace app\subscribe\home;

use app\index\controller\Home;
use QL\QueryList;

/**
 * 大杀器订阅
 */
class Gpress extends Home
{
    public function index()
    {
        $email = input('email', '');
        $password = input('password', '');

        if (empty($email) || empty($password)){
            $this->error('账号或密码不能为空');
        }

        $ql = QueryList::getInstance();

        // 手动设置cookie
        $cookie = new \GuzzleHttp\Cookie\CookieJar();

        $postData = [
            'email' => $email,
            'passwd' => $password,
            'remember_me' => 'week',
        ];

        //提交登录表单
        $actionUrl = 'https://gfw.press/user/_login.php';
        $ql->post($actionUrl, $postData, [
            'cookies' => $cookie
        ]);

        $login_json_str = $ql->getHtml();

        $login_json = json_decode($login_json_str, true);

        // 账号密码错误
        if ($login_json['code'] == 0){
            $this->error($login_json['msg']);
        }

        $ql->get('https://gfw.press/user/index.php', [], [
            'cookies' => $cookie
        ]);

        $data = QueryList::html($ql->getHtml())
            ->rules([
                ['.box-body>table', 'html'],
            ])
            ->query()
            ->getData();

        if (isset($data[0][0]) && !empty($data[0][0])){
            $config_table_html = '<table>' . $data[0][0] . '</table>';  // 获取表格
        }else{
            $this->error('配置获取失败');
        }

        // 解析表格
        $config_table_arr = get_td_array($config_table_html);

        $config = [
            'ip'=>[],
            'port'=>0,
            'password'=>'',
        ];

        // 提取配置
        foreach ($config_table_arr as $value){
            switch ($value[0]){
                case '端口：': // 提取节点端口
                    $config['port'] = $value[1];
                    break;
                case '密码：': // 提取节点密码
                    $config['password'] = $value[1];
                    break;
                default:
                    if (preg_match("/\d+\.\d+\.\d+\.\d+/", $value[1])){ // 提取节点IP
                        $config['ip'][] = $value[1];
                    }
            }
        }

        // 拼装节点
        $subscribe = '';
        foreach($config['ip'] as $key=>$ip){
            $subscribe .= 'gp://' . base64_encode('aes-256-cfb:'.$config['password'].'@'.$ip.':'.$config['port']) . '?remarks=GFW.Press%20-%20' . ($key+1) . '&obfs=none' . chr(10);
        }

        $subscribe = substr($subscribe, 0, -1); // 删除最后的空行

        // 输出订阅内容
        if(!empty($subscribe)){
            return base64_encode($subscribe);
        }
    }
}