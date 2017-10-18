Shadowrocket Subscribe Demo
===============

## 简介

此项目是一个简单的 `Shadowrocket` 的订阅服务端演示程序，通过抓取 [GFW.Press](https://gfw.press) 提供的免费节点来演示 `Shadowrocket` 的 `Subscribe` 功能 (由于目标网站 GFW.Press 被墙，所以你必须部署在墙外的服务器上才行)

## 服务端部署

1. 在 PHP7 的 WEB 环境中安装 [DolphinPHP](http://www.dolphinphp.com/) 系统 (用 `DolphinPHP` 是因为我习惯用这系统来做东西，比较方便)
2. 通过 `Composer` 安装组件 `composer require jaeger/querylist`
3. 用本项目的 `application` 覆盖 DolphinPHP 的 `application` 目录

## Shadowrocket 客户端配置

经过上面步骤得到一个订阅地址 `http://www.xxx.com/subscribe/gpress/大杀器账号/大杀器密码/`

首先启动 `Shadowrocket` 客户端

然后点击右上角的 `+` 加号添加节点，类型选择 `Subscribe`，URL 填写你自己的订阅地址 `http://www.xxx.com/subscribe/gpress/账号/密码/`，备注内容随意

回到 `Shadowrocket` 首页，找到刚才添加的订阅服务，左划一下，点击 `更新` 按钮即可获取到最新 GFW.Press 节点配置

如有需要，可以再配置一下 `Subscribe` 的更新策略，`设置 - 服务器订阅` 把 `打开时更新` 打开

## Workflow

[GFW.Press节点获取](https://workflow.is/workflows/d686433cc2a94315b9b791582d207656)

额外分享一个 GFW.Press 节点获取的 Workflow
