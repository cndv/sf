<?php

namespace app\admin\controller\cms;

use addons\cms\library\aip\AipContentCensor;
use addons\cms\library\SensitiveHelper;
use addons\cms\library\Service;
use app\common\controller\Backend;
use think\Config;
use think\Db;

/**
 * Ajax
 *
 * @icon fa fa-circle-o
 * @internal
 */
class Ajax extends Backend
{

    /**
     * 模型对象
     */
    protected $model = null;
    protected $noNeedRight = ['*'];

    /**
     * 获取模板列表
     * @internal
     */
    public function get_template_list()
    {
        $files = [];
        $keyValue = $this->request->request("keyValue");
        if (!$keyValue) {
            $type = $this->request->request("type");
            $name = $this->request->request("name");
            if ($name) {
                //$files[] = ['name' => $name . '.html'];
            }
            //设置过滤方法
            $this->request->filter(['strip_tags']);
            $config = get_addon_config('cms');
            $themeDir = ADDON_PATH . 'cms' . DS . 'view' . DS . $config['theme'] . DS;
            $dh = opendir($themeDir);
            while (false !== ($filename = readdir($dh))) {
                if ($filename == '.' || $filename == '..') {
                    continue;
                }
                if ($type) {
                    $rule = $type == 'channel' ? '(channel|list)' : $type;
                    if (!preg_match("/^{$rule}(.*)/i", $filename)) {
                        continue;
                    }
                }
                $files[] = ['name' => $filename];
            }
        } else {
            $files[] = ['name' => $keyValue];
        }
        return $result = ['total' => count($files), 'list' => $files];
    }

    /**
     * 检查内容是否包含违禁词
     * @throws \Exception
     */
    public function check_content_islegal()
    {
        $config = get_addon_config('cms');
        $content = $this->request->post('content');
        if (!$content) {
            $this->error(__('Please input your content'));
        }
        if ($config['audittype'] == 'local') {
            // 敏感词过滤
            $handle = SensitiveHelper::init()->setTreeByFile(ADDON_PATH . 'cms/data/words.dic');
            //首先检测是否合法
            $arr = $handle->getBadWord($content);
            if ($arr) {
                $this->error(__('The content is not legal'), null, $arr);
            } else {
                $this->success(__('The content is legal'));
            }
        } else {
            $client = new AipContentCensor($config['aip_appid'], $config['aip_apikey'], $config['aip_secretkey']);
            $result = $client->textCensorUserDefined($content);
            if (isset($result['conclusionType']) && $result['conclusionType'] > 1) {
                $msg = [];
                foreach ($result['data'] as $index => $datum) {
                    $msg[] = $datum['msg'];
                }
                $this->error(implode("<br>", $msg), null, []);
            } else {
                $this->success(__('The content is legal'));
            }
        }
    }

    /**
     * 获取关键字
     * @throws \Exception
     */
    public function get_content_keywords()
    {
        $config = get_addon_config('cms');
        $title = $this->request->post('title');
        $tags = $this->request->post('tags', '');
        $content = $this->request->post('content');
        if (!$content) {
            $this->error(__('Please input your content'));
        }
        $keywords = Service::getContentTags($title);
        $keywords = in_array($title, $keywords) ? [] : $keywords;
        $keywords = array_filter(array_merge([$tags], $keywords));
        $description = mb_substr(strip_tags($content), 0, 200);
        $data = [
            "keywords"    => implode(',', $keywords),
            "description" => $description
        ];
        $this->success("提取成功", null, $data);
    }

    /**
     * 获取标题拼音
     */
    public function get_title_pinyin()
    {
        $config = get_addon_config('cms');
        $title = $this->request->post("title");
        //分隔符
        $delimiter = $this->request->post("delimiter", "");
        $pinyin = new \Overtrue\Pinyin\Pinyin('Overtrue\Pinyin\MemoryFileDictLoader');
        if ($title) {
            if ($config['autopinyin']) {
                $result = $pinyin->permalink($title, $delimiter);
                $this->success("", null, ['pinyin' => $result]);
            } else {
                $this->error();
            }
        } else {
            $this->error(__('Parameter %s can not be empty', 'name'));
        }
    }

    /**
     * 获取表字段列表
     * @internal
     */
    public function get_fields_list()
    {
        $table = $this->request->request('table');
        $fieldList = Service::getTableFields($table);
        $this->success("", null, ['fieldList' => $fieldList]);
    }

    /**
     * 获取自定义字段列表HTML
     * @internal
     */
    public function get_fields_html()
    {
        $this->view->engine->layout(false);
        $source = $this->request->post('source');
        $id = $this->request->post('id/d');
        if (in_array($source, ['channel', 'page', 'special'])) {
            $values = \think\Db::name("cms_{$source}")->where('id', $id)->find();
            $values = $values ? $values : [];

            $fields = \addons\cms\library\Service::getCustomFields($source, 0, $values);

            $this->view->assign('fields', $fields);
            $this->view->assign('values', $values);
            $this->success('', null, ['html' => $this->view->fetch('cms/common/fields')]);
        } else {
            $this->error(__('Please select type'));
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }

    public function get_link_list()
    {
        if ($this->request->isAjax()) {
            $filter = $this->request->request("filter", '', 'trim');
            $filter = (array)json_decode($filter, true);
            $pageList = \app\admin\model\cms\Page::all();
            $specialList = \app\admin\model\cms\Special::all();
            $diyformList = \app\admin\model\cms\Diyform::all();
            $rows = [];
            if (!isset($filter['type']) || $filter['type'] == 'page') {
                foreach ($pageList as $index => $item) {
                    $rows[] = ['type' => 'page', 'url' => $item['url'], 'title' => $item['title'], 'source_id' => $item['id']];
                }
            }
            if (!isset($filter['type']) || $filter['type'] == 'special') {
                foreach ($specialList as $index => $item) {
                    $rows[] = ['type' => 'special', 'url' => $item['url'], 'title' => $item['title'], 'source_id' => $item['id']];
                }
            }
            if (!isset($filter['type']) || $filter['type'] == 'diyform') {
                foreach ($diyformList as $index => $item) {
                    $rows[] = ['type' => 'diyform', 'url' => $item['url'], 'title' => $item['name'] . ' - 列表页', 'source_id' => $item['id']];
                    $rows[] = ['type' => 'diyform', 'url' => $item['post_url'], 'title' => $item['name'] . " - 投稿页", 'source_id' => $item['id']];
                }
            }
            foreach ($rows as $index => $row) {
                if (isset($filter['url']) && stripos($row['url'], $filter['url']) === false) {
                    unset($rows[$index]);
                    continue;
                }
                if (isset($filter['title']) && stripos($row['title'], $filter['title']) === false) {
                    unset($rows[$index]);
                    continue;
                }
            }
            return [
                'rows'  => array_values($rows),
                'total' => count($rows)
            ];
        }
        $typeList = [
            'special' => '专题',
            'page'    => '单页',
            'diyform' => '自定义表单',
        ];
        $this->view->assign('typeList', $typeList);
        return $this->view->fetch('cms/common/links');
    }

    public function config()
    {
        $name = $this->request->get('name');
        if ($name == 'sms') {
            $config = config('addons.hooks');
            if (isset($config['sms_send']) && $config['sms_send']) {
                $name = reset($config['sms_send']);
            } else {
                $this->error("请在插件管理中安装一款短信验证插件", "");
            }
        } elseif ($name == 'oss') {
            $config = config('addons.hooks');
            if (isset($config['upload_config_init']) && $config['upload_config_init']) {
                $availableArr = array_intersect($config['upload_config_init'], ['alioss', 'bos', 'cos', 'upyun', 'ucloud', 'hwobs', 'qiniu']);
                if ($availableArr) {
                    $name = reset($availableArr);
                }
            }
            if (!$name || $name == 'oss') {
                $this->error("请在插件管理中安装一款云存储插件", "");
            }
        } else {
            $info = get_addon_info($name);
            $addonArr = [
                'third'  => '第三方登录',
                'signin' => '会员签到',
                'epay'   => '微信支付宝整合',
            ];
            if (!$info) {
                $this->error('请检查对应插件' . (isset($addonArr[$name]) ? "《{$addonArr[$name]}》" : "") . '是否安装且启动', "");
            }
        }
        $this->redirect('addon/config?name=' . $name . '&dialog=1');
    }

    /**
     * 检测元素是否可用
     * @internal
     */
    public function check_config_available()
    {
        $name = $this->request->request('name');
        $value = $this->request->request('value');
        $name = substr($name, 4, -1);
        if (!$name) {
            $this->error(__('Parameter %s can not be empty', 'name'));
        }
        if ($name == 'theme') {
            if (!preg_match("/^([a-zA-Z0-9\-_]+)$/i", $value)) {
                $this->error("只支持字母数字下划线");
            }
            if (!is_dir(ADDON_PATH . 'cms' . DS . 'view' . DS . $value . DS)) {
                $this->error("皮肤目录不存在");
            }
        } elseif ($name == 'archivesratio') {
            $valueArr = explode(':', $value);
            if (!isset($valueArr[1])) {
                $this->error('格式不正确');
            }
            if (bcadd($valueArr[0], $valueArr[1], 2) != 1) {
                $this->error('分成占比相加必须等于1');
            }
        } elseif ($name == 'cachelifetime') {
            if (!is_numeric($value) && !in_array($value, ['true', 'false'])) {
                $this->error("格式不正确,只支持 数字/true");
            }
        }
        $this->success();
    }

}
